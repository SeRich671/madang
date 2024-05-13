<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
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

    /**
     * Execute the console command.
     */
    public function handle()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        //oddziały
        DB::statement("
            INSERT INTO madang_v2.branches (id, name, email, phone, city, street, zip_code)
            SELECT id, name, email, tel as phone, city, street, zip_code
            FROM madang_remap.branches
        ");

        //działy
        DB::statement("
            INSERT INTO madang_v2.departments (id, name, image, subdomain, status, footer_type)
            SELECT id, name, image, subdomain, status, footer_type
            FROM madang_remap.departments
        ");

        //kategorie produktów
        DB::statement("
            INSERT INTO madang_v2.categories (id, name, transition_only, department_id, category_id)
            SELECT id, name, transitionOnly as transition_only, department_id, category_id
            FROM madang_remap.categories
        ");


        //produkty
        DB::statement("
            INSERT INTO madang_v2.products (
                                            id,
                                            code,
                                            name,
                                            description,
                                            price,
                                            discount_price,
                                            is_available,
                                            is_recommended,
                                            sticker,
                                            later_delivery,
                                            material,
                                            img_path,
                                            size_set,
                                            size_carton,
                                            size,
                                            count_in_package,
                                            last_available
                                            )
            SELECT
                products.id,
                products.code,
                products.name,
                products.description,
                products.price,
                discounts.new_price,
                CASE WHEN product_availables.product_id IS NOT NULL THEN TRUE ELSE FALSE END as is_available,
                CASE WHEN recommended.product_id IS NOT NULL THEN TRUE ELSE FALSE END as is_recommended,
                products.sticker,
                products.later_delivery,
                products.material,
                products.img_path,
                products.size_set,
                products.size_carton,
                products.size,
                products.size_set,
                products.last_available
            FROM madang_remap.products
            LEFT JOIN madang_remap.discounts ON products.id = discounts.product_id
            LEFT JOIN madang_remap.product_availables ON products.id = product_availables.product_id
            LEFT JOIN madang_remap.recommended ON products.id = recommended.product_id
        ");


        //produkt - kategorie
        DB::statement("
            INSERT INTO madang_v2.product_category (id, product_id, category_id)
            SELECT id, product_id, category_id
            FROM madang_remap.product_categories
        ");

        //produkt - oddział
        DB::statement("
            INSERT INTO madang_v2.product_branch (id, product_id, branch_id, is_default)
            SELECT id, product_id, branch_id, is_default
            FROM madang_remap.product_branches
        ");
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
