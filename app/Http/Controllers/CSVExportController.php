<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\StreamedResponse;

class CSVExportController extends Controller
{
    public function downloadCSV()
    {
        $response = new StreamedResponse(function () {
            $handle = fopen('php://output', 'w');

            // เขียน Header ของ CSV
            fputcsv($handle, ['Timestamp', 'Temperature (°C)', 'Humidity (%)', 'Weight (g)', 'Light Intensity (lx)']);

            // ดึงข้อมูลจากฐานข้อมูล
            $data = DB::table('sensor_data')->select('created_at', 'temperature', 'humidity', 'weight', 'light_intensity')->get();

            foreach ($data as $row) {
                fputcsv($handle, [
                    $row->created_at,
                    $row->temperature,
                    $row->humidity,
                    $row->weight,
                    $row->light_intensity
                ]);
            }

            fclose($handle);
        });

        $response->headers->set('Content-Type', 'text/csv');
        $response->headers->set('Content-Disposition', 'attachment; filename="sensor_data.csv"');

        return $response;
    }
}
