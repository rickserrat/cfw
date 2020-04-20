<?php
    $json = file_get_contents("cfw.json");

    $obj = json_decode($json);

    $books = $obj->cfw->books;
    $chapters = $obj->cfw->chapters;

    echo '<h1 class="h1-title">' . $obj->cfw->title;
    echo '<h3 class="text-muted">' . $obj->cfw->description . '</h3></h1>';
   $i = 0;
    echo '<div class="accordion" id="accordionExample">';
    foreach ($chapters as $chapter) {
        $true = $i === 0 ? 'true' : 'false';
        $i = ++$i;
        echo '<div class="card">
              <div class="card-header" id="heading'.$i.'">';
            echo '<h2 class="mb-0">';
                echo '<button class="btn btn-link" type="button" data-toggle="collapse" data-target="#collapse'.$i.'" aria-expanded="'.$true.'" aria-controls="collapse'.$i.'">';
                    echo  $chapter->title . ' - ' . $chapter->description;
                echo '</button>';
            echo '</h2>';
        echo '</div>';

        echo '<div id="collapse'.$i.'" class="collapse" aria-labelledby="heading'.$i.'" data-parent="#accordionExample">
                <div class="card-body">';
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

                echo '<div class="alert alert-primary" role="alert"><strong>Referências bíblicas: </strong>';

                $count = count($paragraph->refs);
                foreach ($paragraph->refs as $ref) {

                   echo '<span class="badge badge-pill badge-primary">' . $ref . '</span> ';
                }
                echo '</div> ';
            }
            echo '</div>
    </div>
  </div>';
    }
    echo '</div>';