<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use PhpOffice\PhpSpreadsheet\IOFactory;

class LibPSGCBrgies extends Seeder
{
    protected $excelFilePath = 'public/system-db-libraries/lib_psgc_brgies.xls'; // Set the path to your Excel file
    protected $table = 'lib_psgc_brgies'; // Set the name of the database table

    public function run()
    {
        // Ensure the Excel file exists
        if (!file_exists($this->excelFilePath)) {
            $this->command->error("The Excel file doesn't exist.");
            return;
        }

        // Read data from Excel using PhpSpreadsheet
        try {
            $spreadsheet = IOFactory::load($this->excelFilePath);
            $worksheet = $spreadsheet->getActiveSheet();
            $data = $worksheet->toArray();
        } catch (\Exception $e) {
            $this->command->error("Error reading the Excel file: " . $e->getMessage());
            return;
        }

        if (count($data) === 0) {
            $this->command->warn("No data found in the Excel file.");
            return;
        }

        // Exclude the first row (header row) and iterate from the second row
        for ($i = 1; $i < count($data); $i++) {
            $row = $data[$i];

            $insertData = [
                'brgy_code' => $row[0] ?? null,
                'brgy_name' => $row[1] ?? null,
                'city_code' => $row[2] ?? null,
                'urb_rur' => $row[3] ?? null,
                'created_at' => now(),
                'updated_at' => now(),
            ];

            // Insert data into the database
            DB::table($this->table)->insert($insertData);
        }

        $this->command->info("Data from the Excel file has been seeded into the database.");
    }
}
