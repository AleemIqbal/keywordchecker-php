<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">

    <title>Keyword Checker</title>
</head>
<body>
    <div class="container">
        <h1 class="text-center mt-4">Keyword Checker</h1>
        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST" class="row g-3 mt-4">
            <div class="col-md-6">
                <label for="sourceCode" class="form-label">Page Source Code</label>
                <textarea name="sourceCode" id="sourceCode" class="form-control" rows="8"></textarea>
            </div>
            <div class="col-md-6">
                <label for="keywords" class="form-label">Keywords (separated by commas)</label>
                <input type="text" name="keywords" id="keywords" class="form-control">
            </div>
            <div class="col-12">
                <button type="submit" class="btn btn-primary mt-3">Check Keywords</button>
            </div>
        </form>
        <?php
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $sourceCode = $_POST['sourceCode'];
            $keywords = $_POST['keywords'];

            if (!empty($sourceCode) && !empty($keywords)) {
                preg_match('/<body[^>]*>(.*?)<\/body>/is', $sourceCode, $matches);
                $bodyContent = isset($matches[1]) ? $matches[1] : '';

                $keywordsArray = explode(',', $keywords);
                $missingKeywords = [];

                foreach ($keywordsArray as $keyword) {
                    $trimmedKeyword = trim($keyword);
                    if (!empty($trimmedKeyword) && stripos($bodyContent, $trimmedKeyword) === false) {
                        $missingKeywords[] = $trimmedKeyword;
                    }
                }

                if (!empty($missingKeywords)) {
                    echo '<div class="alert alert-warning mt-4" role="alert">Missing Keywords:';
                    foreach ($missingKeywords as $missingKeyword) {
                        echo '<span class="badge ms-2">' . htmlspecialchars($missingKeyword) . ',</span>';
                    }
                    echo '</div>';
                } else {
                    echo '<div class="alert alert-success mt-4" role="alert">All keywords are present in the source code.</div>';
                }
            } else {
                echo '<div class="alert alert-danger mt-4" role="alert">Please provide both source code and keywords.</div>';
            }
        }
        ?>
    </div>

    <!-- Bootstrap and jQuery JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
</body>
</html>