<!DOCTYPE html>
<html>

<head>
    <link rel="stylesheet" href="/BOOKSTORE/public/css/style.css">
</head>

<body>
    <div class="panel">
        <h2>Kölcsönzés</h2>

        <form method="POST" action="?action=rent">

            <!-- A könyv sorában kattintott gomb actionja átadja a isbn számot, amit az indexben darabolok és kikeresem hozzá a könyvet. -->
            <!-- Az adatbázisból való kikeresés után visszaadom a könyv fontos adatait megjelenítésre $book változóban. -->
            <label for="bookname">A könyv címe</label>
            <input type="text" name="title" value="<?= htmlspecialchars($book->getTitle()) ?>" readonly>


            <label for="bookauthor">A könyv szerzője</label>
            <input type="text" name="author" value="<?= htmlspecialchars($book->getAuthor()) ?>" readonly>

            <label for="isbn">A könyv ISBN száma</label>
            <input type="text" name="isbn" value="<?= htmlspecialchars($book->getISBN()) ?>" readonly>

            <button type="submit">Kölcsönzés</button>
            <button type="button" onclick=window.history.back(1)>Vissza</button>
        </form>
    </div>

</body>

</html>