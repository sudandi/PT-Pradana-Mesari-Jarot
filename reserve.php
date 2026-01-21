<?php
session_start();
include "connect.php";
include "Includes/templates/header.php";
include "Includes/templates/navbar.php";
include "Includes/functions/functions.php";

if (isset($_POST['reserve_car']) && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $_SESSION['pickup_location'] = test_input($_POST['pickup_location']);
    $_SESSION['return_location'] = test_input($_POST['return_location']);
    $_SESSION['pickup_date'] = test_input($_POST['pickup_date']);
    $_SESSION['return_date'] = test_input($_POST['return_date']);
}
?>

<div class="reserve-banner-section">
    <h2>PESAN MOBIL ANDA</h2>
</div>

<section class="car_reservation_section">
    <div class="container">
        <?php
        if (isset($_POST['submit_reservation']) && $_SERVER['REQUEST_METHOD'] === 'POST') {

            // Ambil data dari form
            $selected_car = $_POST['selected_car'] ?? null;
            $full_name = test_input($_POST['full_name'] ?? '');
            $client_email = test_input($_POST['client_email'] ?? '');
            $client_phonenumber = test_input($_POST['client_phonenumber'] ?? '');
            $pickup_location = $_SESSION['pickup_location'] ?? '';
            $return_location = $_SESSION['return_location'] ?? '';
            $pickup_date = $_SESSION['pickup_date'] ?? '';
            $return_date = $_SESSION['return_date'] ?? '';

            // Validasi sederhana
            if (empty($selected_car) || empty($full_name) || empty($client_email) || empty($client_phonenumber)) {
                echo "<div class='alert alert-danger'>Semua data wajib diisi!</div>";
            } else {
                $con->beginTransaction();
                try {
                    // Insert ke tabel clients
                    $stmtClient = $con->prepare("INSERT INTO clients(full_name, client_email, client_phone) VALUES (?, ?, ?)");
                    $stmtClient->execute([$full_name, $client_email, $client_phonenumber]);

                    // Ambil ID client terbaru
                    $client_id = $con->lastInsertId();
                    if (!$client_id) {
                        throw new Exception("Gagal mendapatkan Client ID.");
                    }

                    // Insert ke tabel reservations
                    $stmt_appointment = $con->prepare("INSERT INTO reservations(client_id, car_id, pickup_date, return_date, pickup_location, return_location) VALUES (?, ?, ?, ?, ?, ?)");
                    $stmt_appointment->execute([$client_id, $selected_car, $pickup_date, $return_date, $pickup_location, $return_location]);

                    echo "<div class='alert alert-success'>Reservasi berhasil dibuat!</div>";
                    $con->commit();
                } catch (Exception $e) {
                    $con->rollBack();
                    echo "<div class='alert alert-danger'>" . $e->getMessage() . "</div>";
                }
            }
        } elseif (isset($_SESSION['pickup_date']) && isset($_SESSION['return_date'])) {
            $pickup_location = $_SESSION['pickup_location'];
            $return_location = $_SESSION['return_location'];
            $pickup_date = $_SESSION['pickup_date'];
            $return_date = $_SESSION['return_date'];

            // Ambil mobil yang tersedia
            $stmt = $con->prepare("
                SELECT DISTINCT 
                    cars.id,
                    cars.car_name,
                    car_brands.brand_name,
                    car_types.type_label
                FROM cars
                INNER JOIN car_brands ON cars.brand_id = car_brands.brand_id
                INNER JOIN car_types ON cars.type_id = car_types.type_id
                LEFT JOIN reservations 
                    ON cars.id = reservations.car_id
                    AND reservations.canceled = 0
                    AND (
                        (? <= reservations.return_date) 
                        AND (? >= reservations.pickup_date)
                    )
                WHERE reservations.car_id IS NULL
            ");
            $stmt->execute([$pickup_date, $return_date]);
            $available_cars = $stmt->fetchAll(PDO::FETCH_ASSOC);
            ?>

            <form action="reserve.php" method="POST" id="reservation_second_form">
                <div class="row" style="margin-bottom: 20px;">
                    <div class="col-md-3 reservation_cards">
                        <p><i class="fas fa-calendar-alt"></i> <span>Tanggal Pengambilan:</span> <?= $pickup_date ?></p>
                    </div>
                    <div class="col-md-3 reservation_cards">
                        <p><i class="fas fa-calendar-alt"></i> <span>Tanggal Pengembalian:</span> <?= $return_date ?></p>
                    </div>
                    <div class="col-md-3 reservation_cards">
                        <p><i class="fas fa-map-marked-alt"></i> <span>Lokasi Penjemputan:</span> <?= $pickup_location ?></p>
                    </div>
                    <div class="col-md-3 reservation_cards">
                        <p><i class="fas fa-map-marked-alt"></i> <span>Lokasi Pengembalian:</span> <?= $return_location ?></p>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-7">
                        <?php foreach ($available_cars as $car) { ?>
                            <div class="itemListElement">
                                <div class="item_details">
                                    <div>
                                        <strong><?= $car['car_name'] ?></strong><br>
                                        <small><?= $car['brand_name'] ?> - <?= $car['type_label'] ?></small>
                                    </div>
                                    <div class="item_select_part">
                                        <label class="item_label btn btn-outline-success">
                                            <input type="radio" name="selected_car" value="<?= $car['id'] ?>" required>
                                            Pilih
                                        </label>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                    </div>

                    <div class="col-md-5">
                        <div class="client_details">
                            <div class="form-group">
                                <label>Nama Lengkap</label>
                                <input type="text" class="form-control" name="full_name" required>
                            </div>
                            <div class="form-group">
                                <label>Email</label>
                                <input type="email" class="form-control" name="client_email" required>
                            </div>
                            <div class="form-group">
                                <label>Nomor Telepon</label>
                                <input type="text" class="form-control" name="client_phonenumber" required>
                            </div>
                            <button type="submit" class="btn sbmt-bttn" name="submit_reservation">Pesan Sekarang</button>
                        </div>
                    </div>
                </div>
            </form>
            <?php
        } else {
            echo "<div class='alert alert-warning'>Silakan pilih tanggal terlebih dahulu.</div>";
            echo "<a href='./#reserve' class='btn btn-info'>Kembali ke Homepage</a>";
        }
        ?>
    </div>
</section>

<?php include "Includes/templates/footer.php"; ?>