<?php
    $json = file_get_contents("cw.json");

    $obj = json_decode($json);

    $books = $obj->cfw->books;
    $chapters = $obj->cfw->chapters;

    echo '<h1>' . $obj->cfw->title . '</h1>';
    echo '<h1>' . $obj->cfw->description . '</h1>';

    foreach ($chapters as $chapter) {
        echo '<h2>' . $chapter->title . '</h2>';
        echo '<h4>' . $chapter->description . '</h4>';

        foreach ($chapter->paragraphs as $paragraph) {
            $str = strpos($paragraph->text, '{{bible}}');

            if($str === false) {
                echo '<p>' . $paragraph->number . ' - ' . $paragraph->text . '</p>';
            }
            else {
                foreach ($books as $book) {
                    $bible .= '<h3>' . $book->title . '</h3>';
                    $bible .= '<p>';

                    foreach ($book->booksName as $bookName) {
                        $bible .= $bookName->name . ', ';
                    }
                    $bible = rtrim($bible, ', ');
                    $bible .= '</p>';

                }
                $text = str_replace('{{bible}}', '</p> ' . $bible . '<p>', $paragraph->text);

                echo '<p>' . $paragraph->number . ' - ' . $text;
            }

            echo '<p><strong>Referências bíblicas:</strong><span> ';

            $count = count($paragraph->refs);
            $i = 0;
            foreach ($paragraph->refs as $ref) {
                if(++$i === $count) {
                    echo $ref . '.';
                    continue;
                }
               echo $ref =  $ref . ' | ';
            }
            echo '</span></p>';
        }
    }
