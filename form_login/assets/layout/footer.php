<style>
    footer {
        color: black;
        text-align: center;
        padding: 15px 20px;
        width: calc(100% - 220px);
        margin-left: 220px;
        position: fixed;
        bottom: 0;
        backdrop-filter: blur(5px);
        background: rgba(255,255,255,0.6);
        transition: all 0.3s ease;
        z-index: 500;
    }

    /* Responsif: kalau layar < 768px */
    @media (max-width: 768px) {
        footer {
            width: 100%;
            margin-left: 0;
            font-size: 14px; /* lebih kecil biar muat */
            padding: 12px 15px;
        }
    }

    /* Tambahan biar aman kalau layar HP banget */
    @media (max-width: 480px) {
        footer {
            font-size: 12px;
            padding: 10px;
        }
    }
</style>

<footer>
    &copy; <?=date('Y')?> UNISBA. All rights reserved.
</footer>
