<!DOCTYPE html>
<html>

<head>
    <link rel="stylesheet" href="/BOOKSTORE/public/css/book_style.css">
</head>

<body>
    <div class="panel">

        <h2>A kikölcsönzött könyvek listája</h2>

        <form>
            <!-- Külön form a POST-hoz: könyv visszaadása -->
             <button type="button" id="back" onclick="location.href='?action=booksDisplay'">Vissza</button>
        </form>

        <!-- Könyv megjelenítési form. -->
        <form method="POST">
            <div class="book-info">
                <table>
                    <tr>
                        <th>Könyv címe</th>
                        <th>Szerző</th>
                        <th>ISBN szám</th>
                        <th>Visszaadás</th>
                    </tr>
                    <tr>
                        <!--Dinamikusan növő táblázat az adatbázisból lekért adatok szerint változik.//-->
                        <?php foreach ($books as $b): ?>
                        <tr>
                            <td>
                                <?= htmlspecialchars($b['title']) ?>
                            </td>
                            <td>
                                <?= htmlspecialchars($b['author']) ?>
                            </td>
                            <td>
                                <?= htmlspecialchars($b['isbn']) ?>
                            </td>
                            <td>
                                <button type="button"
                                    onclick="window.location.href='?action=giveBackShow_<?= $b['isbn'] ?>'">Visszaadom</button>
                            </td>
                        </tr>
                    <?php endforeach; ?>

                    </tr>
                </table>
            </div>
    </div>
    </form>
</body>

</html>