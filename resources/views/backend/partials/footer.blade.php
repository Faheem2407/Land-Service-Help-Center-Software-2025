@php
    $systemSetting = App\Models\SystemSetting::first();
@endphp
<footer class="footer" style="background: #fff">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-6" style="font-size: 16px; color: #000">
                <script>
                    document.write(new Date().getFullYear())
                </script> © {{ $systemSetting->copyright_text}}
            </div>
        </div>
    </div>
</footer>
</div>
<!-- end main content-->