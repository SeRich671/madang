<?php

namespace App\Imports;

use App\Models\Attribute;
use App\Models\Product;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ProductsImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {

        // Ensure "ID internet" exists
        if (!isset($row['id_internet'])) {
            return null;
        }

        // Find product by "ID internet"
        $product = Product::firstOrNew(['code' => $row['id_internet']]);

        // Update only if the field exists in the XLSX file
        $fieldsToUpdate = [
//            'kod' => 'kod',
            'name' => 'nazwa',
            'price' => 'cena_d',
            'price_discount' => 'przecena',
            'in_stock' => 'internet_aktywy',
            'description' => 'opis_internet',
            'count_in_package' => 'ilosc_komplet',
            'size_carton' => 'ilosc_karton',
//            'kategoria' => 'kategoria',
//            'oddzialy' => 'oddzialy',
//            'domyslny_oddzial' => 'domyslny oddzial',
            'is_available' => 'produkt_widoczny',
            'is_recommended' => 'wybrane_na_glowna',
            'bought_by_others' => 'wyswietlac_w_sekcji_inni_kupili_rowniez',
            'later_delivery' => 'opoznienie_w_dostawie',
//            'material' => 'material',
//            'rozmiar' => 'rozmiar',
        ];
        DB::beginTransaction();

        if($product->in_stock == 0 && $row['internet_aktywy'] > 0) {
            $product->markAsNewDelivery();
            $product->markAsLastDelivery();
        }

        foreach ($fieldsToUpdate as $dbField => $xlsxField) {
            if (isset($row[$xlsxField])) {
                $product->$dbField = $row[$xlsxField];
            }
        }

        $product->save();

        if(isset($row['kategoria'])) {
            $categories = collect(explode(',', $row['kategoria']))
                ->map(function ($item) {
                    return (int) $item;
                })
                ->toArray();

            $product->categories()->sync($categories);
        }

        if(isset($row['oddzialy'])) {
            $branches = collect(explode(',', $row['oddzialy']))
                ->mapWithKeys(function ($item) use ($row) {
                    $item = (int)$item;
                    return [
                        $item => [
                            'is_default' => $item == $row['domyslny_oddzial']
                        ]
                    ];
                })
                ->toArray();
            $product->branches()->sync($branches);
        }

        $excludedFields = array_merge(
            array_values($fieldsToUpdate),
            ['kod', 'kategoria', 'oddzialy', 'domyslny_oddzial','id_internet']
        );

        $dynamicAttributes = array_diff_key($row, array_flip($excludedFields));
        $arrayOfDynamic = [];
        foreach ($dynamicAttributes as $attribute => $value) {
            if(is_string($attribute) && isset($value)) {
                $attributeM = Attribute::where('name', 'LIKE', ucfirst($attribute))->first();

                if(!$attributeM) {
                    $attributeM = Attribute::create([
                        'name' => ucfirst($attribute),
                        'is_filter' => 1
                    ]);
                }

                $arrayOfDynamic[$attributeM->id] = [
                    'value' => $value
                ];

            }
        }

        if(count($arrayOfDynamic) > 0) {
            $product->attributes()->sync($arrayOfDynamic);
        }

        DB::commit();
    }
}
