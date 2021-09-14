<?php
    $lokalizacja = "";
    $index = "";

    function zadanie($lokalizacja, $index)
    {

        $pdfy = [];
        $tablica = []; // tablica wyjsciowa

        $lokalizacja =  $lokalizacja."/".$index;

        if(is_dir($lokalizacja))
        {
            $pliki = scandir($lokalizacja);
            foreach ($pliki as $plik)
            {
                if(strpos($plik,"pdf"))
                {
                    $path = $lokalizacja."/".$plik;   //lokalizacja
                    $name = substr($plik, - strlen($plik) , strlen($plik)-4);  //nazwa bez rozszerzenia (z usuniętymi 4 ostatnimi znakami)
                    $size = filesize($path)." bytes"; // rozmiar plików w bitach
                    $creation_date = date("d.m.Y",filemtime($path)); //data utworzenia pliku

                    $pdfy = [$path, $name, $size, $creation_date];

                    // w przypadku gdy nazwa zawiera frazę element z indexem 0 jeśli instnieje przypisuje na koniec i dodaje aktualny w miejsce 0
                    if(strpos($name, "Karta katalogowa PL"))
                    {
                        if(isset($tablica[0]))
                        {
                            array_push($tablica, $tablica[0]);
                        }
                        $tablica[0] = $pdfy;
                    }
                    // to samo dla 1
                    else if(strpos($name, "Karta katalogowa EN"))
                    {
                        if(isset($tablica[1]))
                        {
                            array_push($tablica, $tablica[1]);
                        }
                        $tablica[1] = $pdfy;
                    }
                    else
                    {
                        array_push($tablica, $pdfy);
                    }
                }
            }
        }
        return $tablica;
    }
?>