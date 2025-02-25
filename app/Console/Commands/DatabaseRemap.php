<?php

namespace App\Console\Commands;

use App\Enums\Order\DeliveryEnum;
use App\Enums\Order\PaymentEnum;
use App\Enums\User\RoleEnum;
use App\Enums\User\StatusEnum;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class DatabaseRemap extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:database-remap';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    private $old;

    private $new;

    public function __construct()
    {
        parent::__construct();

        $this->old = DB::connection('mysql_old');
        $this->new = DB::connection('mysql');
    }

    /**
     * Execute the console command.
     */

    public function handle()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        $this->transferDepartments();
        $this->transferBranches();
        $this->transferCategories();
        $this->transferProducts();
//        $this->transferUsers();
//        $this->transferOrders();
//        $this->transferOrderLines();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }

    public function transferDepartments()
    {
        $departments = $this->old->select('select * from site_domains');
        $this->new->delete('DELETE FROM departments WHERE 1');
        foreach ($departments as $department) {
            $this->new->insert("insert into departments (id, email, name, subdomain, image, status) values (?,?,?,?,?,?)", [
                $department->id,
                $department->admin_email,
                $department->name,
                $department->modurl,
                $department->theme_image_left,
                'ON'
            ]);
        }
    }

    public function transferBranches(): void
    {
        $oldBranches = $this->old->select('select * from offer_departments');
        $this->new->delete('DELETE FROM branches WHERE 1');
        foreach ($oldBranches as $branch) {
            $this->new->insert("insert into branches (id, name, email, phone, city, street, zip_code, created_at, updated_at) values (?,?,?,?,?,?,?,?,?)", [
                $branch->id,
                $branch->name,
                $branch->email,
                "Do uzupełnienia",
                "Do uzupełnienia",
                "Do uzupełnienia",
                "Do uzupełnienia",
                $branch->created_at,
                now()
            ]);
        }
    }

    public function transferCategories(): void
    {
        //$problematicIDs = [];
        $this->new->delete('DELETE FROM categories WHERE 1');
        $categories = $this->old->table('offer_tree')->where('lang_id', 1)->get();

        foreach ($categories as $category) {
            $departmentId = $category->domain_id;

            if ($departmentId) {
                $this->new->insert("insert into categories (id, name, department_id, category_id, created_at, updated_at) values (?,?,?,?,?,?)", [
                    $category->id,
                    $category->category_name,
                    $departmentId,
                    $category->id_parent,
                    $category->created_at,
                    now()
                ]);
            }
        }

        $this->new->update('UPDATE categories SET category_id=NULL WHERE category_id = 0');
    }

    public function transferProducts()
    {
        $this->new->delete('DELETE FROM products WHERE 1');
        $this->new->delete('DELETE FROM product_branch WHERE 1');
        $this->new->delete('DELETE FROM product_category WHERE 1');
        $this->new->delete('DELETE FROM attributes WHERE 1');
        $this->new->delete('DELETE FROM product_attribute WHERE 1');
        $products = collect(
            $this->old->select(
            'SELECT DISTINCT offer_products.id,
                offer_products.kod_produktu as code,
                offer_products.name,
                offer_products.department_default_id,
                offer_products.sztuk_w_kartonie as size_carton, 
                offer_products.sztuk_w_komplecie as count_in_package,
                offer_products.stan_ilosciowy as in_stock,
                offer_products.visible as is_available,
                offer_products.created_at as created_at,
                offer_products.updated_at as updated_at,
                kliksklepprodukty.opis_skrot as description_2,
                kliksklepprodukty_madang.opis_skrot as description_1,
                kliksklepprodukty_madang.material as material,
                kliksklepprodukty_madang.rozmiar as size,
                offer_products_prices.price_basic as price,
                pi.name as img_path
                    FROM offer_products
                    LEFT JOIN kliksklepprodukty
                    ON offer_products.kod_produktu = kliksklepprodukty.kod
                    LEFT JOIN kliksklepprodukty_madang
                    ON offer_products.kod_produktu = kliksklepprodukty_madang.kod
                    LEFT JOIN offer_products_prices
                    ON offer_products.id = offer_products_prices.product_id AND currency_id=4
                    LEFT JOIN (
                        SELECT DISTINCT product_id, name
                        FROM offer_products_photos
                        WHERE (product_id, position) IN (
                            SELECT product_id, MIN(position)
                            FROM offer_products_photos
                            GROUP BY product_id
                        )
                    ) pi ON offer_products.id = pi.product_id
                    WHERE offer_products.kod_produktu is not NULL AND offer_products.kod_produktu != "" AND 
                          offer_products.name is not NULL AND offer_products.name != "";
            '
            )
        )->map(function ($item) {
            return (array)$item;
        });

        $dpDefId = $products->filter(function ($item) {
            return $item['department_default_id'];
        })->pluck('department_default_id', 'id');

        $products = $products->transform(function ($item) {
            unset($item['department_default_id']);
            $item['description'] = $item['description_1'] ?: $item['description_2'];
            $item['is_available'] = (bool)$item['is_available'];
            $item['img_path'] = 'upload/products/' . $item['img_path'];
            unset($item['description_1']);
            unset($item['description_2']);
            return $item;
        })->unique('id');

        foreach($products->chunk(3000) as $chunk) {
            $this->new->table('products')->insert($chunk->toArray());
        }

        $productBranches = collect($this->old->select('SELECT id, product_id, department_id as branch_id FROM offer_products_departments'))
            ->map(function ($item) use ($dpDefId) {
                $item = (array)$item;

                $item['is_default'] = isset($dpDefId[$item['id']]);

                return $item;
            });

        foreach($productBranches->chunk(3000) as $chunk) {
            $this->new->table('product_branch')
                ->insert($chunk->toArray());
        }

        $productCategories = collect($this->old->select('SELECT product_id, tree_id as category_id FROM offer_products_tree WHERE lang_id=1'))
            ->map(function ($item) {
                return (array) $item;
            });

        foreach($productCategories->chunk(3000) as $chunk) {
            $this->new->table('product_category')
                ->insert($chunk->toArray());
        }

        $productsWithNoDescription = collect($this->new->select('SELECT id FROM products WHERE description is NULL OR description=""'))
            ->map(function ($item) {
                return $item->id;
            });

        $productDescriptions = collect(
            $this->old->select('SELECT product_id, xhtml as description FROM offer_products_descriptions WHERE lang_id=1')
        );

        foreach($productDescriptions as $prod) {
            if(in_array($prod->product_id, $productsWithNoDescription->toArray())) {
                DB::table('products')
                    ->where('id', $prod->product_id)
                    ->update([
                        'description' => $prod->description
                    ]);
            }
        }

        $this->new->table('attributes')->insert([
            [
                'id' => 20,
                'name' => 'Material',
                'is_filter' => 1,
            ],
            [
                'id' => 21,
                'name' => 'Rozmiar',
                'is_filter' => 1,
            ],
        ]);

        $attributes = collect(
            $this->old->select('
            SELECT product_id, attribute_id, offer_attributes.name as value FROM offer_products_features
            LEFT JOIN offer_attributes
                    ON offer_products_features.value_id = offer_attributes.id
            ')
        )->map(function ($item) {
            return (array)$item;
        });

        foreach($attributes->chunk(3000) as $chunk) {
            $this->new->table('product_attribute')
                ->insert($chunk->toArray());
        }

        echo "All products are transferred\n";
    }

    public function transferUsers() {
        $this->new->delete('DELETE FROM users WHERE 1');
        $this->new->delete('DELETE FROM addresses WHERE 1');
        $this->new->delete('DELETE FROM billings WHERE 1');

        $users = collect(
            $this->old->select('SELECT id, department_id as branch_id, login, name as first_name, surname as last_name, nip, email, phone, 
            company_name, address as company_address, city as company_city, post_code as company_zipcode, fax as company_fax, password, getmailing as marketing,
            activated, uncertain FROM customers_list
            ')
        );

        $time = now();

        $users = $users->map(function ($item) use ($time) {
            $item = (array) $item;
            $item['role'] = RoleEnum::USER;
            $item['status'] = (bool)$item['activated'] ? StatusEnum::ACCEPTED : StatusEnum::NOT_ACCEPTED;
            $item['uncertain'] = (bool)$item['uncertain'];
            $item['marketing'] = (bool)$item['marketing'];
            $item['email_verified_at'] = $time;
            unset($item['activated']);
            return $item;
        })->unique('email')->unique('login');

        foreach ($users->chunk(100) as $chunk)
            $this->new->table('users')->insert($chunk->toArray());

//        $admins = collect(
//            $this->old->select('SELECT login, email, password FROM app_users
//            ')
//        )->map(function ($item) {
//            $item = (array) $item;
//            $item['first_name'] = 'Admin';
//            $item['last_name'] = 'Admin';
//            return $item;
//        });
//
//        User::whereIn('login', $admins->pluck('login'))->delete();
//
//        $this->new->table('users')->insert($admins->toArray());

        $addresses = collect(
            $this->old->select('
                SELECT
                    id,
                    customer_id as user_id,
                    name as first_name,
                    surname as last_name,
                    company as company_name,
                    address as street,
                    city,
                    post_code as zip_code,
                    phone
                FROM customers_address_book 
            ')
        )->map(function ($item) {
            return (array) $item;
        });

        foreach($addresses->chunk(3000) as $chunk) {
            $this->new->table('addresses')->insert($chunk->toArray());
        }

        $billings = collect(
            $this->old->select('
                SELECT
                    customers_address_book.id,
                    customers_address_book.customer_id as user_id,
                    customers_address_book.name as first_name,
                    customers_address_book.surname as last_name,
                    customers_address_book.company as company_name,
                    customers_address_book.address as address,
                    customers_address_book.city,
                    customers_address_book.post_code as zipcode,
                    customers_address_book.phone,
                    customers_address_book.nip,
                    customers_list.email as email
                FROM customers_address_book
                JOIN customers_list
                ON customers_address_book.customer_id=customers_list.id
            ')
        )->map(function ($item) {
            if(!$item->nip) {
                $item->nip = 'xxx-xxx-xxx-xxx';
            }
            return (array) $item;
        });

        foreach($billings->chunk(3000) as $chunk) {
            $this->new->table('billings')->insert($chunk->toArray());
        }
    }

    private function transferOrders()
    {
        $this->new->delete('DELETE FROM orders WHERE 1');
        $this->new->delete('DELETE FROM order_lines WHERE 1');

        $orders = collect(
            $this->old->select('
                SELECT 
                    shop_orders.id as id,
                    order_key as code,
                    department_id as branch_id,
                    customer_id as user_id,
                    comment as description,
                    delivery_id as delivery,
                    payment_id as payment,
                    delivery_price as delivery_cost,
                    payment_price as payment_cost,
                    total_value as total,
                    status_id as status,
                    shop_orders.email as billing_email,
                    address as address_json
                FROM shop_orders
                LEFT JOIN shop_orders_address
                ON shop_orders.id=shop_orders_address.order_id
            ')
        )->map(function ($item) {
            $item = (array) $item;
            try{
                $address = unserialize($item['address_json']);
            } catch (\Throwable $e) {
                return;
            }


            $item['address_first_name'] = $address['name'];
            $item['address_last_name'] = $address['surname'];
            $item['address_company_name'] = $address['company'];
            $item['address_address'] = $address['address'];
            $item['address_city'] = $address['city'];
            $item['address_zipcode'] = $address['post_code'];
            $item['address_phone'] = $address['phone'];

            $item['billing_first_name'] = $address['name'];
            $item['billing_last_name'] = $address['surname'];
            $item['billing_company_name'] = $address['company'];
            $item['billing_address'] = $address['address'];
            $item['billing_city'] = $address['city'];
            $item['billing_zipcode'] = $address['post_code'];
            $item['billing_phone'] = $address['phone'];
            $item['billing_nip'] = 'xxx-xxx-xxx-xxx';

            switch ($item['status']) {
                case 1:
                    $item['status'] = \App\Enums\Order\StatusEnum::NEW;
                    break;
                case 2:
                    $item['status'] = \App\Enums\Order\StatusEnum::IN_PROGRESS;
                    break;
                case 3:
                    $item['status'] = \App\Enums\Order\StatusEnum::DONE;
                    break;
                case 4:
                    $item['status'] = \App\Enums\Order\StatusEnum::ABORTED;
                    break;
            }

            switch ($item['delivery']) {
                case 1:
                case 2:
                    $item['delivery'] = DeliveryEnum::COURIER;
                    break;
                case 5:
                    $item['delivery'] = DeliveryEnum::PICK_UP;
                    break;
            }

            switch ($item['payment']) {
                case 1:
                    $item['payment'] = PaymentEnum::PREPEYMENT;
                    break;
                case 2:
                case 3:
                    $item['payment'] = PaymentEnum::POSTPAYMENT;
                    break;
            }

            unset($item['address_json']);

            return $item;
        })->filter(function ($item) {
            return $item !== null;
        });

        foreach ($orders->chunk(500) as $chunk) {
            $this->new->table('orders')
                ->insert($chunk->toArray());
        }
    }

    private function transferOrderLines() {
        $this->new->delete('DELETE FROM order_lines WHERE 1');

        $lines = collect(
            $this->old->select('
                SELECT 
                    id,
                    order_id,
                    domain_id as department_id,
                    product_id as product_id,
                    qty as quantity,
                    price,
                    unavailable
                FROM shop_orders_products
            ')
        )->map(function ($item) {
            return (array)$item;
        });

        foreach ($lines->chunk(3000) as $chunk) {
            $this->new->table('order_lines')
                ->insert($chunk->toArray());
        }
    }
}
