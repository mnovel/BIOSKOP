<?php
define('MENU_TITLE', "Tambah Film");
include "../../header.php";
?>
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1><?= MENU_TITLE ?></h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
                <div class="breadcrumb-item"><a href="#">Layout</a></div>
                <div class="breadcrumb-item">Default Layout</div>
            </div>
        </div>

        <div class="section-body">
            <div class="card">
                <div class="card-header">
                    <h4>Cari Film</h4>
                </div>
                <div class="card-body">
                    <form action="" method="GET">
                        <div class="form-group">
                            <div class="input-group mb-3">
                                <input type="text" class="form-control" placeholder="Judul Film" name="judul" id="judul" value="<?= empty($_GET['judul']) ? '' : ucwords(urldecode($_GET['judul'])) ?>">
                                <input type="text" class="form-control" placeholder="Tahun Terbit" name="tahun" id="tahun" value="<?= empty($_GET['tahun']) ? '' : ucwords(urldecode($_GET['tahun'])) ?>">
                                <div class="input-group-append">
                                    <button class="btn btn-primary" type="submit">Cari Film</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <?php

            if (!empty($_GET['judul'])) {
                $judul = urlencode($_GET['judul']);
                $tahun = urlencode(empty($_GET['tahun']) ? '' : $_GET['tahun']);
                $curl = curl_init();
                curl_setopt_array($curl, [
                    CURLOPT_URL => "https://api.themoviedb.org/3/search/movie?query=$judul&include_adult=true&language=en-US&page=1&year=$tahun",
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_HTTPHEADER => [
                        'Authorization: Bearer eyJhbGciOiJIUzI1NiJ9.eyJhdWQiOiIxNDgwODhhODQzYWFjZjg3ODQzNjZlOTBiNGE1OTM4ZCIsInN1YiI6IjYwYzg2ODY3MTg4NjRiMDA2ZTJjYmQ1ZiIsInNjb3BlcyI6WyJhcGlfcmVhZCJdLCJ2ZXJzaW9uIjoxfQ.L3wY_ELyTYpGOuSP_UC3YYATnX6UUWhofp0dwmA3CSc',
                        'accept: application/json',
                    ],
                ]);
                $response = json_decode(curl_exec($curl));
                curl_close($curl);
            ?>
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
                    foreach ($response->results as $res) :
                    ?>
                        <div class="col-12 col-md-6 col-lg-3 mb-5">
                            <div class="card film-card h-100">
                                <img src="https://image.tmdb.org/t/p/w600_and_h900_bestv2/<?= $res->poster_path ?>" class="card-img-top" alt="Film 1">
                                <div class="card-body">
                                    <h5 class="card-title"><?= $res->original_title ?></h5>
                                    <ul class="list-group list-group-flush mb-3">
                                        <li class="list-group-item"><?= substr($res->overview, 0, 150) ?><?= strlen($res->overview) > 100 ? '...' : '' ?></li>
                                        <li class="list-group-item">Tanggal Rilis : <?= $res->release_date ?></li>
                                        <li class="list-group-item">Rating : <?= $res->popularity ?></li>
                                    </ul>
                                </div>
                                <div class="card-footer text-center">
                                    <a href="<?= BASE_URL ?>admin/list-film?id=<?= $res->id ?>" class="col-6 btn btn-primary">Tambah</a>
                                </div>
                            </div>
                        </div>
                    <?php endforeach ?>

                </div>
            <?php } ?>
        </div>
    </section>
</div>
<?php
include "../../footer.php";
?>