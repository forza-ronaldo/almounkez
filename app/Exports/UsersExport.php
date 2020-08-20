<?php

namespace App\Exports;

use App\Role;
use App\User;
use Illuminate\Database\Eloquent\Builder;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;


class UsersExport implements FromCollection ,WithHeadings,WithMapping,WithColumnFormatting
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public $users;
    public function __construct($users)
    {
        $this->users=$users;
    }
    public function headings(): array
    {
        return [__('site.id'),__('site.name'),__('site.email'),__('site.created_at'),__('site.updated_at')];
    }
    public function map($invoice): array
    {
        return [
            $invoice->id,
            $invoice->name,
            $invoice->email,
            Date::dateTimeToExcel($invoice->created_at),
            Date::dateTimeToExcel($invoice->updated_at),
        ];
    }

    public function columnFormats(): array
    {
        return [
            'D' => NumberFormat::FORMAT_DATE_DDMMYYYY,
            'E' => NumberFormat::FORMAT_DATE_DDMMYYYY,
        ];
    }
    public function collection()
    {
        return $this->users;
    }
}
