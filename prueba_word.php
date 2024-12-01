<?php
require 'vendor/autoload.php';


use PhpOffice\PhpWord\IOFactory;
use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\TemplateProcessor;

// Cargar el archivo Word existente
$templateProcessor = new TemplateProcessor('anexo_1.docx');

// Modificar los campos
$templateProcessor->setValue('nombre', 'Luias Jhonntan sanchez');
$templateProcessor->setValue('field2', 'Nuevo Valor 2');
// ... puedes seguir añadiendo más campos y valores

// Guardar el documento modificado
$templateProcessor->saveAs('anexo_1.docx');

echo "El documento ha sido modificado y guardado correctamente.";