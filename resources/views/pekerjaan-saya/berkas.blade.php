<style>
    @page {
        size: A4 landscape;
        margin: 0;
    }

    body {
        background: url('{{ public_path("assets/sertifikat.jpg") }}') no-repeat center center;
        background-size: cover;
        height: 100%;
        width: 100%;
        margin: 0;
        position: relative;
        font-family: 'Arial', sans-serif;
    }

    .content {
        position: absolute;
        top: 55%;
        left: 50%;
        transform: translate(-50%, -50%);
        text-align: center;
        color: white;
    }

    .nama {
        font-size: 40px;
        font-family: 'dancing_script';
        color: #f7da92;
        margin-bottom: 70px;
    }

    .poin {
        font-size: 24px;
        font-family: 'belleza';
        color: #f7da92;
        margin-bottom: 130px;
    }


</style>

<div class="content">
    <p class="nama">{{ strtoupper($nama) }}</p>
    <div class="poin">
        <span>POIN TERTINGGI</span> <br>
        <span>{{ $jumlah_poin }} POIN</span>
    </div>
</div>
