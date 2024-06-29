<?php

namespace App\Exports;

use App\Models\Warehouse;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStrictNullComparison;
use Maatwebsite\Excel\Events\AfterSheet;

class WarehousesExport implements FromCollection, WithHeadings, ShouldAutoSize, WithStrictNullComparison, WithCustomStartCell, WithEvents
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        $products = Warehouse::query()->get();
        $products->load('product', 'exports');
        foreach ($products as $product) {
            $product->exports->quantity = $product->exports->sum('pivot.quantity');
            $product->name = $product->product->name;
            $product->export_quantity = $product->exports->quantity;
        }

        return $products->select('name', 'quantity', 'export_quantity');
    }

    public function headings(): array
    {
        return [
            'Sản phẩm',
            'Số lượng tồn',
            'Số lượng bán',
        ];
    }

    public function startCell(): string
    {
        return 'A2';
    }

    /**
     * @return array
     */
    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $event->sheet->setCellValue('A1', 'Bảng thống kê danh sách sản phẩm vật tư');
                $event->sheet->mergeCells("A1:C1");
                $event->sheet->getStyle('A1:C1')->getAlignment()->setHorizontal('center');
                $event->sheet->getRowDimension(1)->setRowHeight(20);
            },
        ];
    }
}
