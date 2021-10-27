<?php
session_start();
$record = $_SESSION['var'];
?>
<article>
    <!-- Excerpt Start -->
    <div class="card text-dark bg-info mb-3" style="max-width: 18rem;">
        <div class="card-body">
            <?php if ($record->hide_my_name == 0) { ?>
                <h5 class="card-title"><?php echo $record->your_name ?></h5>
            <?php } ?>
            <h6 class="card-subtitle mb-2 text-muted"><?php echo $record->title ?></h6>
            <p class="card-text"><?php echo $record->years_of_experience ?> years of experience</p>
            <?php
            if ($record->hide_my_email == 0) { ?>
                <a href="mailto: <?php echo $record->your_email ?>" class="card-link"><?php echo $record->your_email ?></a>
            <?php } ?>
        </div>
    </div>
    <!-- Excerpt End -->
    <section>
        <div>
            <h2>Role Description</h2>
            <p>
                <?php echo $record->role_description ?>
            </p>
        </div>

        <div>
            <h2>Feedback</h2>
            <p>
                <?php echo $record->feedback ?>
            </p>
        </div>

        <div>
            <h2>Advice For Beginners</h2>
            <p>
                <?php echo $record->advice_for_beginners ?>
            </p>
        </div>
    </section>
</article>