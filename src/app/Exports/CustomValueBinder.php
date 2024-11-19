<?php

namespace App\Exports;

use PhpOffice\PhpSpreadsheet\Cell\Cell;
use PhpOffice\PhpSpreadsheet\Cell\DefaultValueBinder;
use PhpOffice\PhpSpreadsheet\Cell\IValueBinder;

class CustomValueBinder extends DefaultValueBinder implements IValueBinder
{
    public function bindValue(Cell $cell, mixed $value): bool
    {
        // Contoh: Mengatur semua nilai sebagai teks
        $cell->setValueExplicit($value, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);

        // Mengembalikan true untuk menunjukkan bahwa bindValue berhasil
        return true;
    }
}