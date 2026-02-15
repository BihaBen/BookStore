<!DOCTYPE html>
<html>

<head>
    <link rel="stylesheet" href="/BOOKSTORE/public/css/book_style.css">
</head>

<body>
    <div class="panel">
        <h2>Kölcsönzés</h2>

        <!-- Keresőmező formja -->
        <form method="POST" action="?action=search">

            <!-- Külön form a POST-hoz -->
            <input id="searchBar_input" type="text" name="searchbar" placeholder="Keresőmező:">

        </form>

        <!-- Könyv megjelenítési form. -->
        <form method="POST" action="?action=booksDisplay">
            <div class="book-info">
                <table>
                    <tr>
                        <th>Könyv címe</th>
                        <th>Szerző</th>
                        <th>ISBN szám</th>
                        <th>Kölcsönzés</th>
                        <th>Szerkesztés</th>
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
                                <button type="button"  onclick="window.location.href='?action=rent'">Kölcsönzés</button>
                            </td>
                            <td>
                                <button type="button"  onclick="window.location.href='?action=modify'">Módosítás</button>
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