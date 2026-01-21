<?php 
    #PHP INCLUDES
    include "connect.php";
    include "Includes/templates/header.php";
    include "Includes/templates/navbar.php";
?>

<!-- Home Section -->
<section class = "home_section">
    <div class="section-header">
        <div class="section-title" style = "font-size:50px; color:#04DBC0">
            Sewa Mobil Tanpa Ribet, Cuma di PT Pradana Mesari Jarot
        </div>
        <hr class="separator">
		<div class="section-tagline">
            Mulai dari Rp. 200.000,00 per hari dengan diskon penawaran waktu terbatas
		</div>					
	</div>
</section>

<!-- Our Services Section -->
<section class = "our-services" id = "services">
    <div class = "container">
        <div class="section-header">
            <div class="section-title">
                Layanan yang Ditawarkan
            </div>
            <hr class="separator">
            <div class="section-tagline">
                Kami mendukung keberlanjutan dengan menyediakan unit hemat energi dan servis efisien.
            </div>
        </div>
        <div class="row">
            <div class="col-lg-4 col-md-6">
                <div class="single-feature">
                    <h4>
                        <span>
                            <i class="far fa-user"></i>
                        </span>
                        Teknisi Ahli
                    </h4>
                    <p>
                        Kami memiliki tim teknisi berpengalaman yang selalu siap memastikan kondisi unit tetap prima dan aman digunakan.
                    </p>
                </div>
            </div>
            <div class="col-lg-4 col-md-6">
                <div class="single-feature">
                    <h4>
                        <span>
                            <i class="fas fa-certificate"></i>
                        </span>
                        Layanan Profesional
                    </h4>
                    <p>
                        Layanan kami mengutamakan kenyamanan pelanggan, dengan proses sewa yang mudah, cepat, dan transparan.
                    </p>
                </div>
            </div>
            <div class="col-lg-4 col-md-6">
                <div class="single-feature">
                    <h4>
                        <span>
                            <i class="fas fa-phone-alt"></i>
                        </span>
                        Dukungan Luar Biasa
                    </h4>
                    <p>
                        Tim customer service kami siap membantu Anda kapan saja dengan respons cepat dan solusi terbaik.
                    </p>
                </div>
            </div>
            <div class="col-lg-4 col-md-6">
                <div class="single-feature">
                    <h4>
                        <span>
                            <i class="fas fa-rocket"></i>
                        </span>
                        Keterampilan Teknis
                    </h4>
                    <p>
                        Setiap kendaraan dirawat oleh staf yang memiliki keterampilan tinggi dalam bidang otomotif dan teknologi terkini.
                    </p>
                </div>
            </div>
            <div class="col-lg-4 col-md-6">
                <div class="single-feature">
                    <h4>
                        <span>
                            <i class="fas fa-gem"></i>
                        </span>
                        Sangat Direkomendasikan
                    </h4>
                    <p>
                        Kami dipercaya oleh banyak pelanggan sebagai pilihan utama rental mobil yang terpercaya dan berkualitas.
                    </p>
                </div>
            </div>
            <div class="col-lg-4 col-md-6">
                <div class="single-feature">
                    <h4>
                        <span>
                            <i class="far fa-comments"></i>
                        </span>
                        Ulasan Positif
                    </h4>
                    <p>
                        Pelanggan kami selalu puas dengan layanan yang diberikan, terbukti dari berbagai ulasan positif yang kami terima.
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- About Area Section -->
<section class = "about-area">
    <div class = "container-fluid">
        <div class = "row">
            <div class = "col-md-6 left-area" style = "padding:0px">
                <img src="Design/images/about-img.png" alt="Car Rental Image">
            </div>
            <div class = "col-md-6 right-area" style = "padding:50px">
                <h1>
                    Solusi Transportasi Andal <br>
                    untuk Segala Kebutuhan
                </h1>
                <p>
                    <span>
                        Kami mengutamakan kenyamanan, keamanan, dan kemudahan dalam setiap perjalanan Anda.
                    </span>
                </p>
                <p>
                    PT Pradana Mesari Jarot hadir untuk memenuhi kebutuhan transportasi Anda, baik untuk perjalanan bisnis, liburan keluarga, hingga acara khusus. Dengan unit yang selalu terawat dan proses pemesanan yang mudah, kami pastikan pengalaman berkendara Anda selalu nyaman dan aman.
                </p>
                <a class="my-btn bttn" href="#brands">Lihat Unit Kami</a>
            </div>
        </div>
    </div>
</section>

<!-- Our Brands Section -->
<section class = "our-brands" id = "brands">
    <div class = "container">
        <div class="section-header">
            <div class="section-title">
                Jelajahi Unit Kami
            </div>
            <hr class="separator">
            <div class="section-tagline">
                Setiap unit dalam koleksi kami dirawat secara berkala, memastikan kenyamanan dan keamanan di setiap perjalanan.
            </div>
        </div>
        <div class = "car-brands">
            <div class = "row">
            <?php

                $stmt = $con->prepare("Select * from car_brands");
                $stmt->execute();
                $car_brands = $stmt->fetchAll();

                foreach($car_brands as $car_brand)
                {
                    $car_brand_img = "admin/Uploads/images/".$car_brand['brand_image'];
                    ?>
                    <div class = "col-md-4">
                        <div class = "car-brand" style = "background-image: url(<?php echo $car_brand_img ?>);">
                            <div class = "brand_name">
                                <h3>
                                    <?php echo $car_brand['brand_name']; ?>
                                </h3>
                            </div>
                        </div>
                    </div>
                    <?php
                }

            ?>
            </div>
        </div>
    </div>
</section>

<!-- CAR RESERVATION SECTION -->
<section class="reservation_section" style = "padding:50px 0px" id = "reserve">
	<div class="container">
		<div class = "row">
			<div class = "col-md-5"></div>
			<div class = "col-md-7">
				<form method="POST" action = "reserve.php" class = "car-reservation-form" id = "reservation_form" v-on:submit = "checkForm">
					<div class="text_header">
						<span>
							Pilih Unit
						</span>
					</div>
					<div>
						<div class = "form-group">
							<label for="pickup_location">Lokasi Penjemputan</label>
							<input type = "text" class = "form-control" name = "pickup_location" placeholder = "Masukkan alamat tempat Anda ingin mulai perjalanan" v-model = 'pickup_location'>
							<div class="invalid-feedback" style = "display:block" v-if="pickup_location === null">
								Lokasi penjemputan diperlukan
							</div>
						</div>
						<div class = "form-group">
							<label for="return_location">Lokasi Pengembalian</label>
							<input type = "text" class = "form-control" name = "return_location" placeholder = "Masukkan alamat tujuan akhir atau lokasi pengembalian mobil" v-model = 'return_location'>
							<div class="invalid-feedback" style = "display:block" v-if="return_location === null">
								Lokasi pengembalian diperlukan
							</div>
						</div>
						<div class = "form-group">
							<label for="pickup_date">Tanggal Penjemputan</label>
							<input type = "date" min = "<?php echo date('Y-m-d', strtotime("+1 day"))?>" name = "pickup_date" class = "form-control" v-model = 'pickup_date'>
							<div class="invalid-feedback" style = "display:block" v-if="pickup_date === null">
								Tanggal penjemputan diperlukan
							</div>
						</div>
						<div class = "form-group">
							<label for="return_date">Tanggal Pengembalian</label>
							<input type = "date" min = "<?php echo date('Y-m-d', strtotime("+2 day"))?>" name = "return_date"  class = "form-control" v-model = 'return_date'>
							<div class="invalid-feedback" style = "display:block" v-if="return_date === null">
								Tanggal pengembalian diperlukan
							</div>
						</div>
						<!-- Submit Button -->
						<button type="submit" class="btn sbmt-bttn" name = "reserve_car">Pesan Sekarang</button>
					</div>
				</form>
			</div>
		</div>
	</div>
</section>

<!-- CONTACT SECTION -->

<section class="contact-section" id="contact-us">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 sm-padding">
                <div class="contact-info">
                    <h2>
                        Hubungi Kami & 
                        <br>Kirim Pesan Hari Ini!
                    </h2>
                    <p>
                        Jangan ragu untuk menghubungi kami — Tim kami siap membantu segala kebutuhan perjalanan Anda. Bersama PT Pradana Mesari Jarot, setiap perjalanan menjadi lebih nyaman, aman, dan tak terlupakan.
                    </p>
                    <h3>
                        Jl. Glogor Carik no. 72 
                        <br>
                        Pemogan, Denpasar Selatan, 80221
                    </h3>
                    <ul>
                        <li>
                            <span style = "font-weight: bold">Email:</span> 
                            PTPradanaMesariJarot@gmail.com
                        </li>
                        <li>
                            <span style = "font-weight: bold">Phone:</span> 
                            +6281228653435
                        </li>
                        <li>
                            <span style = "font-weight: bold">Fax:</span> 
                            +6281228653435
                        </li>
                    </ul>
                </div>
            </div>
            <div class="col-lg-6 sm-padding">
                <div class="contact-form">
                    <div id="contact_ajax_form" class="contactForm">
                        <div class="form-group colum-row row">
                            <div class="col-sm-6">
                                <input type="text" id="contact_name" name="name" class="form-control" placeholder="Name">
                            </div>
                            <div class="col-sm-6">
                                <input type="email" id="contact_email" name="email" class="form-control" placeholder="Email">
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-12">
                                <input type="text" id="contact_subject" name="subject" class="form-control" placeholder="Subject">
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-12">
                                <textarea id="contact_message" name="message" cols="30" rows="5" class="form-control message" placeholder="Message"></textarea>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-12">
                                <button id="contact_send" class="contact_send_btn">Send Message</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Footer Section -->
<section class="widget_section">
    <div class="container">
        <div class="row">
            <div class="col-lg-4 col-md-6">
                <div class="footer_widget">
                    <a class="navbar-brand" href="">
                        PT <span style = "color:#04DBC0">Pradana Mesari</span>&nbsp;Jarot
                    </a>
                    <p>
                        Nikmati perjalanan yang aman dan nyaman bersama kami. Bersama teman atau keluarga, perjalanan Anda akan menjadi pengalaman yang tak terlupakan.
                    </p>
                    <ul class="widget_social">
                        <li><a href="#" data-toggle="tooltip" title="Facebook"><i class="fab fa-facebook-f fa-2x"></i></a></li>
                        <li><a href="#" data-toggle="tooltip" title="Twitter"><i class="fab fa-twitter fa-2x"></i></a></li>
                        <li><a href="#" data-toggle="tooltip" title="Instagram"><i class="fab fa-instagram fa-2x"></i></a></li>
                        <li><a href="#" data-toggle="tooltip" title="LinkedIn"><i class="fab fa-linkedin fa-2x"></i></a></li>
                        <li><a href="#" data-toggle="tooltip" title="Google+"><i class="fab fa-google-plus-g fa-2x"></i></a></li>
                    </ul>
                </div>
            </div>
            <div class="col-lg-4 col-md-6">
                <div class="footer_widget">
                    <h3>Contact Info</h3>
                    <ul class = "contact_info">
                        <li>
                            <i class="fas fa-map-marker-alt"></i>Jl. Glogor Carik no. 72 Pemogan, Denpasar Selatan, 80221
                        </li>
                        <li>
                            <i class="far fa-envelope"></i>PTPradanaMesariJarot@gmail.com
                        </li>
                        <li>
                            <i class="fas fa-mobile-alt"></i>+6281228653435
                        </li>
                    </ul>
                </div>
            </div>
            <div class="col-lg-4 col-md-6">
                <div class="footer_widget">
                    <h3>Newsletter</h3>
                    <p style = "margin-bottom:0px">Jangan lewatkan promo menarik kami! Daftar sekarang untuk mendapatkan penawaran eksklusif langsung ke email Anda.</p>
                    <div class="subscribe_form">
                        <form action="#" class="subscribe_form" novalidate="true">
                            <input type="email" name="EMAIL" id="subs-email" class="form_input" placeholder="Email Address...">
                            <button type="submit" class="submit">SUBSCRIBE</button>
                            <div class="clearfix"></div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- BOTTOM FOOTER -->
<?php include "Includes/templates/footer.php"; ?>



<script>

new Vue({
    el: "#reservation_form",
    data: {
        pickup_location: '',
        return_location: '',
        pickup_date: '',
		return_date: ''
    },
    methods:{
        checkForm: function(event){
            if( this.pickup_location && this.return_location && this.pickup_date && this.return_date)
            {
                return true;
            }
            
            if (!this.pickup_location)
            {
                this.pickup_location = null;
            }

            if (!this.return_location)
            {
                this.return_location = null;
            }

            if (!this.pickup_date)
            {
                this.pickup_date = null;
            }

			if (!this.return_date)
            {
                this.return_date = null;
            }
            
            event.preventDefault();
        },
    }
})


</script>