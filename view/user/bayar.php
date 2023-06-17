<?php
define('MENU_TITLE', "Booking");
include "../../header2.php";
?>
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
            <div class="invoice">
                <div class="invoice-print">
                    <?php
                    $query = "SELECT BOOKING.TANGGAL, JAM_TAYANG.JAM, FILM.UUID, JAM_TAYANG.HARGA FROM BOOKING  JOIN JAM_TAYANG ON JAM_TAYANG.ID = BOOKING.ID_JAM_TAYANG JOIN FILM ON FILM.UUID = JAM_TAYANG.ID_FILM WHERE ID_JAM_TAYANG = :ID_JAM_TAYANG AND ID_USERS = (SELECT ID FROM USERS WHERE USERNAME = :USERNAME)";
                    $parse = oci_parse($con, $query);

                    $jam = $_GET['jam'];
                    $username = $_SESSION['login']['username'];

                    oci_bind_by_name($parse, ':ID_JAM_TAYANG', $jam);
                    oci_bind_by_name($parse, ':USERNAME', $username);

                    oci_execute($parse);

                    $res = oci_fetch_assoc($parse);
                    ?>
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="invoice-title">
                                <h2>Invoice</h2>
                                <div class="invoice-number">Order #12345</div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-md-6">
                                    <address>
                                        <strong>Judul:</strong><br>
                                        <?= getDetailFilm($_GET['film'])->original_title ?>
                                    </address>
                                </div>
                                <div class="col-md-6 text-md-right">
                                    <address>
                                        <strong>Tanggal:</strong><br>
                                        <?= date("d F Y", strtotime($res['JAM'])) ?>
                                    </address>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <address>
                                        <strong>Jam:</strong><br>
                                        <?= date("H:i:s", strtotime($res['JAM'])) . ' WIB' ?>
                                    </address>
                                </div>
                                <div class="col-md-6 text-md-right">
                                    <address>
                                        <strong>Order Date:</strong><br>
                                        <?= date("d F Y H:i:s", strtotime($res['TANGGAL'])) . ' WIB' ?>
                                    </address>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php
                    oci_free_statement($parse);
                    ?>

                    <div class="row mt-4">
                        <div class="col-md-12">
                            <div class="section-title">Order Summary</div>
                            <p class="section-lead">All items here cannot be deleted.</p>
                            <div class="table-responsive">
                                <table class="table table-striped table-hover table-md">
                                    <tr>
                                        <th data-width="40">#</th>
                                        <th>No Kursi</th>
                                        <th class="text-center">Studio</th>
                                        <th class="text-right">Totals</th>
                                    </tr>
                                    <?php
                                    $query = "SELECT B.KURSI, J.HARGA, S.NAMA FROM BOOKING B JOIN JAM_TAYANG J ON J.ID = B.ID_JAM_TAYANG JOIN STUDIO S ON S.ID = J.ID_STUDIO WHERE ID_JAM_TAYANG = :ID_JAM_TAYANG AND ID_USERS = (SELECT ID FROM USERS WHERE USERNAME = :USERNAME)";
                                    $parse = oci_parse($con, $query);

                                    $jam = $_GET['jam'];
                                    $username = $_SESSION['login']['username'];

                                    oci_bind_by_name($parse, ':ID_JAM_TAYANG', $jam);
                                    oci_bind_by_name($parse, ':USERNAME', $username);

                                    oci_execute($parse);
                                    $no = 1;
                                    while ($res = oci_fetch_assoc($parse)) {
                                    ?>
                                        <tr>
                                            <td><?= $no++ ?></td>
                                            <td><?= $res['KURSI'] ?></td>
                                            <td class="text-center"><?= $res['NAMA'] ?></td>
                                            <td class="text-right"><?= formatRupiah($res['HARGA']) ?></td>
                                        </tr>
                                    <?php }
                                    oci_free_statement($parse);
                                    ?>
                                </table>
                            </div>
                            <div class="row mt-4">
                                <div class="col align-self-end text-right">
                                    <div class="invoice-detail-item">
                                        <div class="invoice-detail-name">Total</div>
                                        <?php
                                        $query = "SELECT SUM( J.HARGA ) AS HARGA, B.STATUS FROM BOOKING B JOIN JAM_TAYANG J ON J.ID = B.ID_JAM_TAYANG WHERE B.ID_JAM_TAYANG = :ID_JAM_TAYANG AND B.ID_USERS = ( SELECT ID FROM USERS WHERE USERNAME = :USERNAME ) GROUP BY B.ID_JAM_TAYANG, ID_USERS, B.STATUS";
                                        $parse = oci_parse($con, $query);

                                        $jam = $_GET['jam'];
                                        $username = $_SESSION['login']['username'];

                                        oci_bind_by_name($parse, ':ID_JAM_TAYANG', $jam);
                                        oci_bind_by_name($parse, ':USERNAME', $username);

                                        oci_execute($parse);
                                        $res = oci_fetch_assoc($parse)
                                        ?>
                                        <div class="invoice-detail-value invoice-detail-value-lg mb-3"><?= formatRupiah($res['HARGA']) ?></div>
                                        <button class="btn btn-<?= $res['STATUS'] == 1 ? 'danger' : 'success' ?> btn-sm"><?= $res['STATUS'] == 1 ? 'Belum Lunas' : 'Lunas' ?></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <hr>
                <div class="text-md-right">
                    <div class="float-lg-left mb-lg-0 mb-3">
                        <?php if ($res['STATUS'] == 1) { ?>
                            <button class="btn btn-primary btn-icon icon-left" data-toggle="modal" data-target="#bayar"><i class="fas fa-credit-card"></i> Process Payment</button>
                        <?php }  ?>
                        <button class="btn btn-warning btn-icon icon-left" onclick="history.back()"><i class="fas fa-times"></i> Kembali</button>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <div class="modal fade" tabindex="-1" role="dialog" id="bayar">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form action="<?= BASE_URL ?>proses/bayar" enctype="multipart/form-data" method="POST">
                    <div class="modal-header">
                        <h5 class="modal-title">Upload Bukti Transaksi</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="">File</label>
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" id="foto" name="foto">
                                <input type="hidden" name="jam" id="jam" value="<?= $_GET['jam'] ?>">
                                <label class="custom-file-label" for="customFile">Choose file</label>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer bg-whitesmoke br">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Kembali</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?php
include "../../footer2.php";
?>