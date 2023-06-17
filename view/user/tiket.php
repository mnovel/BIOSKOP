<?php
// http://localhost/bioskop/user/bayar?film=123&jam=5
define('MENU_TITLE', "Tiket");
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
            <div class="card">
                <div class="card-header">
                    <h4>List Studio</h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped" id="table-1">
                            <thead>
                                <tr>
                                    <th class="text-center">
                                        #
                                    </th>
                                    <th>Studio</th>
                                    <th>Waktu</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $query = "SELECT DISTINCT J.ID_FILM, J.JAM, J.ID FROM BOOKING B JOIN JAM_TAYANG J ON J.ID = B.ID_JAM_TAYANG  WHERE ID_USERS = (SELECT ID FROM USERS WHERE USERNAME = :USERNAME)";
                                $parse = oci_parse($con, $query);
                                oci_bind_by_name($parse, ':USERNAME', $_SESSION['login']['username']);
                                oci_execute($parse);
                                $no = 1;
                                while ($res = oci_fetch_assoc($parse)) {
                                ?>
                                    <tr>
                                        <td><?= $no++ ?></td>
                                        <td><?= getDetailFilm($res['ID_FILM'])->original_title ?></td>
                                        <td><?= date('d F Y H:i:s', strtotime($res['JAM'])) ?> WIB</td>
                                        <td>
                                            <a href="<?= BASE_URL ?>user/bayar?film=<?= $res['ID_FILM'] ?>&jam=<?= $res['ID'] ?>" class="btn btn-warning btn-sm"><i class="fas fa-tags"></i></a>
                                        </td>
                                    </tr>
                                <?php }
                                oci_free_statement($parse);
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
<?php
include "../../footer2.php";
?>