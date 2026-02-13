<!DOCTYPE html>
<html>

<head>
    <link rel="stylesheet" href="/BOOKSTORE/public/css/book_style.css">
</head>

<body>
    <div class="panel">
        <h2>Kölcsönzés</h2>

        <form method="POST" action="?action=books_display">
            <input type="text" name="searchbar" placeholder="Keresőmező:" required>
        </form>
        <div class="book-info">
        <table >
            <tr>
                <th>Könyv címe</th>
                <th>Szerző</th>
                <th>ISBN szám</th>
                <th>Kölcsönzés</th>
                <th>Szerkesztés</th>
            </tr>
            <tr>
                <td>
                    "A Pál utcai fiúk"
                </td>
                <td>
                    "Molnár Ferenc"
                </td>
                <td>
                    "978-0-7334-2609-4"
                </td>
                <td>
                    <button>Kölcsönzés</button>
                </td>
                <td>
                    <button>Könyv módosítása</button>
                </td>
            </tr>
        </table>
    </div>
    </div>

    

</body>

</html>