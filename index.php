<?php 
require 'PrintFormatter.php';
$formatter = new PrintFormatter;
$data = $formatter->text('P R E B I L L I N G', 'center')
                  ->text('RST0000000001', 'center')
                  ->line('double')
                  ->formFormats([
                    'date' => date('Y-m-d'),
                    'Server' => 'Server 1',
                    'Shift' => 'Shift 1',
                    'stujuhs' => 'kgfk'
                  ])
                  // ->line('double')
                  // ->item(1, 'Lorem ipsum dolorgg kkjhkjh', 2, 300000)
                  // ->newLine()
                  // ->item(2, 'Lorem ipsum dolorgg kkjhkjh', 2, 3000)
                  // ->newLine()
                  // ->item(3, 'Lorem ipsum dolorgg', 2, 10000000)
                  // ->newLine()->line()
                  // ->newLine()
                  ->table(['Satu', 'dua', 'tiga', 'empat'])
                  ->line()
                  ->customTable([
                        ['text' => '1', 'align' => 'LEFT', 'width' => 0.15],
                        ['text' => 'Item 1', 'align' => 'CENTER', 'width' => 0.5],
                        ['text' => '10000', 'align' => 'RIGHT', 'width' => 0.5],                        
                    ])
                  ->customTable([
                        ['text' => '2', 'align' => 'LEFT', 'width' => 0.15],
                        ['text' => 'Item 2', 'align' => 'CENTER', 'width' => 0.5],
                        ['text' => '100000', 'align' => 'RIGHT', 'width' => 0.5],                        
                    ])
                  ->generate();

$handle = fopen('result.txt', 'w');

fwrite($handle, $data);
fclose($handle);