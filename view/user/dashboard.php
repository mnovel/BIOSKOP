<?php
define('MENU_TITLE', "Dashboard");
include "../../header2.php";
?>
<!-- Main Content -->
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1><?= MENU_TITLE ?></h1>
            <div class="section-header-breadcrumb">
                <!-- <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
                <div class="breadcrumb-item"><a href="#">Layout</a></div>
                <div class="breadcrumb-item">Top Navigation</div> -->
            </div>
        </div>
        <div class="section-body">
            <h2 class="section-title">Now Showing</h2>
            <style>
                .film-card {
                    border-radius: 10px;
                    overflow: hidden;
                    box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
                    transition: transform 0.3s ease;
                    margin-bottom: 15px;
                }

                .film-card:hover {
                    transform: scale(1.05);
                }
            </style>

            <div class="row">
                <?php
                $query = "SELECT DISTINCT ID_FILM FROM JAM_TAYANG WHERE JAM > SYSDATE";
                $parse = oci_parse($con, $query);
                oci_execute($parse);

                while ($res = oci_fetch_assoc($parse)) {
                    $fetch = getDetailFilm($res['ID_FILM']);
                ?>
                    <div class="col-12 col-lg-4 mb-5">
                        <a href="<?= BASE_URL ?>user/booking?film=<?= $res['ID_FILM'] ?>">
                            <div class="card film-card h-100">
                                <img src="https://image.tmdb.org/t/p/w600_and_h900_bestv2/<?= $fetch->poster_path ?>" class="card-img-top" alt="Film 1">
                                <div class="card-body">
                                    <h5 class="card-title"><?= $fetch->original_title ?></h5>
                                    <p class="card-text"><?= substr($fetch->overview, 0, 200) ?></p>
                                </div>
                            </div>
                        </a>
                    </div>
                <?php
                }
                oci_free_statement($parse);
                ?>
            </div>
        </div>
    </section>
</div>

<?php
include "../../footer2.php";
?>