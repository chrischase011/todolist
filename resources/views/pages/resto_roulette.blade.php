@extends('layouts.app')
@section('title', 'Resto-Roulette - ' . config('app.name', 'Laravel'))
@section('content')


    <div class="container text-center">
        <h2 class="text-white text-center">Resto-Roulette</h2>
        <div class="row mt-3">
            <div class="col-md-8 border border-white">
                <br><br><br>
                <div class="row container mt-5 pb-4">
                    <div class="col-3"><span class="fw-bold fs-5 text-white">></span></div>
                    <div class="col-6">
                        <div class="resto-container"><span id="resto-data" class="text-white h3"></span></div>
                    </div>
                    <div class="col-3"><span class="fw-bold fs-5 text-white">
                            < </span>
                    </div>

                </div>

                <div class="container mt-5 d-flex justify-content-center">

                    <button type="button" id="spin" class="btn btn-primary btn-lg w-100" onclick="spinResto()"
                        disabled>Spin</button>
                    <button type="button" id="stop" class="btn btn-danger btn-lg w-100 d-none"
                        onclick="stopResto()">Stop</button>
                </div>
            </div>
            <div class="col-md-4 border border-white p-3">
                <h4 class="text-white text-center">Please input any resto here <br><span class="h5">(please separate
                        with
                        comma)</span></h4>
                <textarea class="form-control w-100" id="resto" rows="10" style="resize: none"></textarea>
                <button type="button" class="btn btn-secondary text-center mt-3" onclick="randomize()">Randomize</button>
            </div>
        </div>

        <script>
            $(() => {
                // Load data from cookie
                var data = $.cookie("resto");

                if (data !== null || data !== "")
                    $("#resto").val(data);

                // Array data

                var resto = $("#resto").val();
                console.log(resto);
                if (resto) {
                    $("#spin").prop('disabled', false);
                } else {

                    $("#spin").prop('disabled', true);
                    $("#resto-data").text("");
                }

                var arr = resto.split(",");
                // Load first data on resto-data
                $("#resto-data").text(arr[0].trim());



            });
            // Save resto to browser cookie every 2.5 seconds
            setInterval(() => {
                var resto = $("#resto").val();

                if (resto) {
                    $("#spin").prop('disabled', false);

                } else {

                    $("#spin").prop('disabled', true);
                    $("#resto-data").text("");
                }

                $.cookie("resto", resto, {
                    expires: 1000,
                    secure: true
                });

                console.log("Cookie updated");
            }, 2500);


            // var isTimer = false;
            var isSpinning = false;
            var timer;

            function spinResto() {
                isSpinning = true;
                console.log("Spinning");
                var resto = $("#resto").val();
                console.log(resto);

                var arr = resto.split(",");
                $("#stop").removeClass("d-none")
                $("#spin").addClass("d-none");
                timer = setInterval(() => {
                    $("#resto-data").text(arr[Math.floor(Math.random() * arr.length)].trim());
                    //Math.floor(Math.random() * arr.length)
                }, 10);
            }

            function stopResto() {
                isSpinning = false;
                $("#stop").addClass("d-none")
                $("#spin").removeClass("d-none");
                clearInterval(timer);
            }


            function randomize() {
                var resto = $("#resto").val();

                var arr = resto.split(",");
                for (var i = arr.length - 1; i > 0; i--) {
                    var j = Math.floor(Math.random() * (i + 1));
                    var temp = arr[i].trim();
                    arr[i] = arr[j].trim();
                    arr[j] = temp.trim();
                }
                var randomize = arr.join(", ");
                $("#resto").val(randomize);
                $("#resto-data").text(arr[0].trim());
            }
        </script>

    @endsection