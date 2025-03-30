<!-- show for toast start -->
<!-- show for toast start -->
<!-- show for toast start -->
<!-- show for toast start -->
<!-- show for toast start -->
<!-- show for toast start -->
<!-- show for toast start -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
< script src = "https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"
integrity = "sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p"
crossorigin = "anonymous" >
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js"
    integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous">
</script>




<div id="notification-toastgreen"
    style="position: fixed; z-index: 100; bottom: 3%; right: 4%;!important; background:green !important"
    class="toast align-items-center text-bg-success border-0" role="alert" aria-live="assertive" aria-atomic="true"
    data-autohide="true" data-delay="2000" style="margin-left:7%;">
    <div class="d-flex">
        <div class="toast-body">
            {{ session('greentoast') }}
        </div>
        <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"
            aria-label="Close">X</button>
    </div>
</div>

<div id="notification-toastred"
    style="position: fixed; z-index: 100; bottom: 3%; right: 4%;!important; background:#FF9C07 !important"
    class="toast align-items-center text-bg-warning border-0" role="alert" aria-live="assertive" aria-atomic="true"
    data-autohide="true" data-delay="3000" style="margin-left:7%;">
    <div class="d-flex">
        <div class="toast-body">
            {{ session('redtoast') }}
        </div>
        <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"
            aria-label="Close">X</button>
    </div>
</div>

<!-- end for show toast -->
<!-- end for show toast -->
<!-- end for show toast -->
<!-- end for show toast -->
<!-- end for show toast -->
<script>
////////// show toast start
var successMessage = "{{ session('greentoast') }}";
if (successMessage) {
    var toast = new bootstrap.Toast(document.querySelector('#notification-toastgreen'), {
        animation: true,
        autohide: true,
        delay: 3000
    });
    toast.show();
}

var failMessage = "{{ session('redtoast') }}";
if (failMessage) {
    var toast = new bootstrap.Toast(document.querySelector('#notification-toastred'), {
        animation: true,
        autohide: true,
        delay: 3000
    });
    toast.show();
}

///////////////// show toast end 
</script>