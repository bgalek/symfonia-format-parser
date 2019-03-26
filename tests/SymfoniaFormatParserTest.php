<?php

use PHPUnit\Framework\TestCase;
use SymfoniaFormatParser\SymfoniaFormatParser;

class SymfoniaFormatParserTest extends TestCase
{
    public function testProductsParsing()
    {
        given:
        $input = file_get_contents('input/products.txt', FILE_USE_INCLUDE_PATH);

        when:
        $parsed = SymfoniaFormatParser::parse($input);

        then:
        $this->assertEquals(['INFO', 'TypyCen', 'StawkaVAT', 'Towar'], array_keys($parsed));
        $this->assertEquals(['\'Sage Symfonia 2.0 Handel 2019.c\' Symfonia 2.0 Handel 2019.c', '219', '3.2', [
            'id' => '-162862888',
            'kod' => 'Demo_HM',
            'nazwa' => 'Firma Demonstracyjna',
            'miejscowosc' => 'Zamość',
            'ulica' => 'ul. Bazyliańska',
            'dom' => '19',
            'lokal' => '5',
            'kodpocz' => '22-400',
            'rejon' => 'lubelskie',
            'nip' => '000-000-00-00',
            'tel1' => '3321075',
            'tel2' => '1844748',
            'fax' => '3321076',
            'email' => 'demo@demo.com.pl',
            'www' => ''
        ]], array_values($parsed['INFO']));
        $this->assertEquals(12, count($parsed['Towar']));
        $this->assertEquals(
            [
                'Diana 12F grzałka SP1',
                'Diana 12F profil przedni',
                'Bęben do pralki Diana 12F',
                'Grzałka do pralki Diana 12F',
                'Programator do pralki Diana 12F',
                'diana komplet',
                'Montaż i podłączenie pralki do instal...',
                'Pralka "Diana 12F"',
                'usługa transportowa',
                'diana zestaw',
                'licencja "kod XXDSF64526"',
                'produkty rolne'
            ], array_map(function ($el) {
            return $el['nazwa'];
        }, $parsed['Towar']));
    }

    public function testPartnersParsing()
    {
        given:
        $input = file_get_contents('input/clients.txt', FILE_USE_INCLUDE_PATH);

        when:
        $parsed = SymfoniaFormatParser::parse($input);

        then:
        $this->assertEquals(32, count($parsed['Kontrahent']));
        $this->assertEquals(
            [
                ['Elektron sp. z o.o.', 'Warszawa'],
                ['AGD Adam', 'Zamość'],
                ['Agora Gazeta', 'Warszawa'],
                ['Altkom Matrix SA', 'Warszawa'],
                ['Auto SALEon s.c.', 'Warszawa'],
                ['AUTO Shop', 'Brno'],
                ['Bank PKO SA', 'Warszawa'],
                ['BIZNESPARTNER.PL SA', 'Warszawa'],
                ['Chińska fabryka obuwia', 'Pekin'],
                ['DemoFK', 'Warszawa'],
                ['Edelweiss SA Oddział Zwierzyniec', 'Zwierzyniec'],
                ['Edelweiss SA', 'Krasnystaw'],
                ['Elektron sp. z o.o.', 'Warszawa'],
                ['Herr Flueck', 'Hannover'],
                ['Herr Flueck KG', 'Hannover'],
                ['Jan Kowalski', 'Wola Michowska'],
                ['Kornel Kobza i ska', 'Radom'],
                ['Kornex sp. z o.o.', 'Zamość'],
                ['Matrix.pl SA', 'Warszawa'],
                ['Matrix.pl SA', 'Warszawa'],
                ['MATRIX.PL SA', 'Warszawa'],
                ['Mechaniczeskij Optowyj', 'Donieck'],
                ['Mechaniczeskij Optowyj', 'Donieck'],
                ['Nowak Jan', 'Warszawa'],
                ['Office Depot', 'Warszawa'],
                ['Philips UK Ltd', 'London'],
                ['SAGE SYMFONIA Sp. z o.o.', 'Warszawa'],
                ['TP SA', 'Warszawa'],
                ['Ulrich von J und Sohn', 'Braunschweig'],
                ['Urlich von J und Sohn GmbH', 'Braunschweig'],
                ['Warski sc.', 'Szczebrzeszyn'],
                ['Fundacja Wiedza Powszechna', 'Warszawa'],
            ], array_map(function ($el) {
            return [$el['nazwa'], $el['miejscowosc']];
        }, $parsed['Kontrahent']));
    }
}


