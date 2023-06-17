<?php
define('MENU_TITLE', "Booking");
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
                $fetch = getDetailFilm($_GET['film']);
                ?>
                <div class="col-12 col-lg-4 mb-5">
                    <div class="card film-card h-100">
                        <img src="https://image.tmdb.org/t/p/w600_and_h900_bestv2/<?= $fetch->poster_path ?>" class="card-img-top" alt="Film 1">
                        <div class="card-body">
                            <h5 class="card-title"><?= $fetch->original_title ?></h5>
                            <p class="card-text"><?= substr($fetch->overview, 0, 200) ?></p>
                        </div>
                    </div>
                </div>
                <div class="col mb-5">
                    <div class="card">
                        <div class="card-header">
                            <h4>Jadwal Jam Tayang</h4>
                        </div>
                        <div class="card-body">
                            <div class="form-group">
                                <select class="form-control select2" name="studio" id="studio" onchange="<?= "window.location='?film=" . $_GET['film'] . "&jam='+this.value" ?>">
                                    <option value="0" selected disabled>Pilih..</option>
                                    <?php
                                    $query = "SELECT * FROM JAM_TAYANG WHERE ID_FILM = :ID_FILM";
                                    $parse = oci_parse($con, $query);
                                    oci_bind_by_name($parse, ':ID_FILM', $_GET['film']);
                                    oci_execute($parse);
                                    while ($res = oci_fetch_assoc($parse)) {
                                    ?>
                                        <option value="<?= $res['ID'] ?>" <?= !empty($_GET['jam']) && $res['ID'] == $_GET['jam'] ? 'selected' : '' ?>><?= date("d F Y H:i:s", strtotime($res['JAM'])) ?></option>
                                    <?php
                                    }
                                    oci_free_statement($parse);
                                    ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="card <?= empty($_GET['jam']) ? 'd-none' : '' ?>">
                        <div class="card-header">
                            <h4>Pilih Kursi</h4>
                        </div>
                        <div class="card-body">
                            <h4 class="text-center">LAYAR</h4>
                            <hr width="50%" class="text-center">
                            <form action="<?= BASE_URL ?>proses/booking" method="POST">
                                <input type="hidden" name="jam" id="jam" value="<?= $_GET['jam'] ?>">
                                <input type="hidden" name="film" id="film" value="<?= $_GET['film'] ?>">
                                <div class="row">
                                    <div class="col">
                                        <div class="form-group">
                                            <label class="form-label"></label>
                                            <?php
                                            function cekKursi($kursi, $jam)
                                            {
                                                global $con;
                                                $query = "SELECT * FROM BOOKING WHERE ID_JAM_TAYANG = :ID_JAM_TAYANG AND KURSI = :KURSI";
                                                $parse = oci_parse($con, $query);

                                                oci_bind_by_name($parse, ':ID_JAM_TAYANG', $jam);
                                                oci_bind_by_name($parse, ':KURSI', $kursi);

                                                oci_execute($parse);
                                                return oci_fetch($parse);
                                            }

                                            $alphachar = array_merge(range('A', 'J'));
                                            foreach ($alphachar as $res) :
                                            ?>
                                                <div class="selectgroup w-100">
                                                    <?php
                                                    for ($i = 1; $i <= 5; $i++) {
                                                    ?>
                                                        <label class="selectgroup-item">
                                                            <input type="radio" name="kursi-<?= $res . $i ?>-<?= cekKursi($res . $i, $_GET['jam'])  ? 'done' : '' ?>" value="<?= $res . $i ?>" class="selectgroup-input" <?= cekKursi($res . $i, $_GET['jam'])  ? 'checked' : '' ?>>
                                                            <span class="selectgroup-button"><?= $res . $i ?></span>
                                                        </label>
                                                    <?php } ?>
                                                </div>
                                            <?php endforeach ?>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="form-group">
                                            <label class="form-label"></label>
                                            <?php
                                            $alphachar = array_merge(range('A', 'J'));
                                            foreach ($alphachar as $res) :
                                            ?>
                                                <div class="selectgroup w-100">
                                                    <?php
                                                    for ($i = 6; $i <= 10; $i++) {
                                                    ?>
                                                        <label class="selectgroup-item">
                                                            <input type="radio" name="kursi-<?= $res . $i ?>-<?= cekKursi($res . $i, $_GET['jam'])  ? 'done' : '' ?>" value="<?= $res . $i ?>" class="selectgroup-input" <?= cekKursi($res . $i, $_GET['jam'])  ? 'checked' : '' ?>>
                                                            <span class="selectgroup-button"><?= $res . $i ?></span>
                                                        </label>
                                                    <?php } ?>
                                                </div>
                                            <?php endforeach ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="text-center">
                                    <button class="btn btn-primary col-12 col-lg-8" type="submit">Booking</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<?php
include "../../footer2.php";
?>