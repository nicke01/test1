<?php
class client
{
    protected $list = array();

    public function load($d)
    {
        $xml = new DOMDocument();
        $url = 'http://www.cbr.ru/scripts/XML_daily.asp?date_req=' . date($d);

        if (@$xml->load($url))
        {
            $this->list = array();

            $root = $xml->documentElement;
            $items = $root->getElementsByTagName('Valute');

            foreach ($items as $item)
            {
                $code = $item->getElementsByTagName('CharCode')->item(0)->nodeValue;
                $curs = $item->getElementsByTagName('Value')->item(0)->nodeValue;
                $this->list[$code] = floatval(str_replace(',', '.', $curs));
            }

            return true;
        }
        else
            return false;
    }

    public function get($cur)
    {
        return isset($this->list[$cur]) ? $this->list[$cur] : 0;
    }
}

$cbr = new client();
if ($cbr->load('25.03.2020')){
    $y_usd_curs = $cbr->get('USD');
    $t_usd_curs = $cbr->get('USD');
}

echo "dollar: " . $y_usd_curs . " -> " . $t_usd_curs . "</br>";

if ($cbr->load('26.03.2020')){
    $y_eur_curs = $cbr->get('EUR');
    $t_eur_curs = $cbr->get('EUR');
}

echo "euro: " . $y_eur_curs . " -> " . $t_eur_curs;
