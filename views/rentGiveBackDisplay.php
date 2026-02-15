<head>
    <link rel="stylesheet" href="/BOOKSTORE/public/css/style.css">
</head>

<body>
<div class="panel">
    <h2>A vissza adni kívánt könyv</h2>

    <?php if (!empty($error)): ?>
        <div style="color: red; margin-bottom: 15px;">
            <?= htmlspecialchars($error) ?>
        </div>
    <?php endif; ?>

    <form method="POST" action="?action=giveBack">

        <label for="bookname">A könyv címe</label>
        <input type="text" id="bookname" name="title"
               value="<?= isset($book) ? htmlspecialchars($book->getTitle()) : '' ?>"
               readonly>

        <label for="bookauthor">A könyv szerzője</label>
        <input type="text" id="bookauthor" name="author"
               value="<?= isset($book) ? htmlspecialchars($book->getAuthor()) : '' ?>"
               readonly>

        <label for="isbn">A könyv ISBN száma</label>
        <input type="text" id="isbn" name="isbn"
               value="<?= isset($book) ? htmlspecialchars($book->getISBN()) : '' ?>"
               readonly>

        <button type="submit">Visszaad</button>

        <!-- stabil visszalépés: könyvlistára -->
        <button type="button" onclick="location.href='index.php?action=giveBackDisplay'">Vissza</button>
    </form>
</div>
</body>
