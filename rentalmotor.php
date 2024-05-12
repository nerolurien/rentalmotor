<head>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
</head>

<div class="container">
    <div class="row">
        <div class="col-md-6 offset-md-3">
            <form method="post" class="border p-3">
                <h1 class="text-center mb-3">Rental Motor</h1>

                <div class="form-group">
                    <label for="nama_pelanggan">Nama Pelanggan:</label>
                    <input type="text" id="nama_pelanggan" name="nama_pelanggan" required class="form-control">
                </div>

                <div class="form-group">
                    <label for="lama_waktu_rental">Lama Waktu Rental (per hari):</label>
                    <input type="number" id="lama_waktu_rental" name="lama_waktu_rental" required class="form-control">
                </div>

                <div class="form-group">
                    <label for="jenis_motor">Jenis Motor:</label>
                    <select id="jenis_motor" name="jenis_motor" required class="form-control">
                        <option value="">-- Pilih Jenis Motor --</option>
                        <option value="scooter">Scooter</option>
                        <option value="Vario">Vario</option>
                        <option value="Adv">Adv</option>
                        <option value="Nmax">Nmax</option>
                    </select>
                </div>

                <button type="submit" class="btn btn-primary btn-block">Submit</button>
            </form>
        </div>
    </div>
</div>

<?php

class RentalMotor {
    private $namaPelanggan;
    private $lamaWaktuRental;
    private $hargaRentalPerHari;
    private $tambahanPajak;
    private $memberArray;

    public function __construct($namaPelanggan, $lamaWaktuRental, $hargaRentalPerHari, $tambahanPajak, $memberArray) {
        $this->namaPelanggan = $namaPelanggan;
        $this->lamaWaktuRental = $lamaWaktuRental;
        $this->hargaRentalPerHari = (int)$hargaRentalPerHari;
        $this->tambahanPajak = $tambahanPajak;
        $this->memberArray = $memberArray;
    }

    public function hitungHargaRental() {
        $hargaRental = $this->lamaWaktuRental * $this->hargaRentalPerHari + $this->tambahanPajak;
        if (in_array($this->namaPelanggan, $this->memberArray)) {
            $diskon = 0.05 * $hargaRental; // 5% discount for members
            $hargaSetelahDiskon = $hargaRental - $diskon;
            return $hargaSetelahDiskon;
        }
        return $hargaRental;
    }
}

// Define member array
$memberArray = array('Ana', 'Budi', 'Cici', 'Dedi');

// Define motor types and prices
$motorTypes = array(
    'scooter' => 70000,
    'Vario' => 90000,
    'Nmax' => 110000,
    'Adv' => 130000
);

if (isset($_POST['nama_pelanggan'], $_POST['lama_waktu_rental'], $_POST['jenis_motor'])) {
    $namaPelanggan = $_POST['nama_pelanggan'];
    $lamaWaktuRental = $_POST['lama_waktu_rental'];
    $jenisMotor = $_POST['jenis_motor'];
    $hargaRentalPerHari = $motorTypes[$jenisMotor];
    $tambahanPajak = 10000;
        $rentalMotor = new RentalMotor($namaPelanggan, $lamaWaktuRental, $hargaRentalPerHari, $tambahanPajak, $memberArray);
        $hargaRental = $rentalMotor->hitungHargaRental();

        echo "<table class='table table-bordered mt-3'><tbody>";
        echo "<tr><th class='text-center'>Detail</th><th class='text-center'>Keterangan</th></tr>";
        echo "<tr><td>Nama pelanggan</td><td class='text-center'>" . $namaPelanggan . "</td></tr>";
        if (in_array($namaPelanggan, $memberArray)) {
            echo "<tr><td>Status</td><td class='text-center'>Member</td></tr>";
            echo "<tr><td>Diskon</td><td class='text-center'>5%</td></tr>";
        } else {
            echo "<tr><td>Status</td><td class='text-center'>Bukan Member</td></tr>";
        }
        echo "<tr><td>Jenis motor</td><td class='text-center'>" . $jenisMotor . "</td></tr>";
        echo "<tr><td>Lama rental</td><td class='text-center'>" . $lamaWaktuRental . " hari</td></tr>";
        echo "<tr><td>Harga rental</td><td class='text-center'>Rp. " . number_format($hargaRental, 0, ',', '.') . "</td></tr>";
        echo "</tbody></table>";
    }

