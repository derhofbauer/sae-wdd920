Links

<?php

/**
 * @todo: comment
 */
$links = [
    'https://sae.edu',
    'https://google.com',
    'https://nasa.gov'
];

var_dump($_SESSION);

?>


<ul>
    <?php foreach ($links as $link): ?>
        <li>
            <a href="http://localhost:8080/uebungen/3.1/helpers/redirector.php?url=<?php echo urlencode($link); ?>" target="_blank"><?php echo $link; ?></a>
            <?php if (isset($_SESSION['urls']) && in_array($link, $_SESSION['urls'])) {
                echo "besucht";
            } ?>
        </li>
    <?php endforeach; ?>
</ul>
