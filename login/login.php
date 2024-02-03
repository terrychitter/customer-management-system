<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Login</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" />
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    <link rel="stylesheet" href="style.css" />
    <link rel="stylesheet" href="/global.css" />
</head>
<style>
    .lds-dual-ring {
        display: inline-block;
    }

    .lds-dual-ring:after {
        content: " ";
        display: block;
        width: 1.8rem;
        height: 1.8rem;
        margin: 8px;
        border-radius: 50%;
        border: 6px solid #4169e1;
        border-color: #4169e1 transparent #4169e1 transparent;
        animation: lds-dual-ring 1.2s linear infinite;
    }

    @keyframes lds-dual-ring {
        0% {
            transform: rotate(0deg);
        }

        100% {
            transform: rotate(360deg);
        }
    }
</style>

<body class="d-flex align-items-center">
    <?php
    include "../popup.php";
    ?>
    <svg id="waves" viewBox="0 0 1440 590" xmlns="http://www.w3.org/2000/svg"
        class="transition duration-300 ease-in-out delay-150" style="z-index: -1">
        <style>
            .path-0 {
                animation: pathAnim-0 30s;
                animation-timing-function: linear;
                animation-iteration-count: infinite;
            }

            #waves {
                position: absolute;
                bottom: 0;
            }

            @keyframes pathAnim-0 {
                0% {
                    d: path("M 0,600 C 0,600 0,200 0,200 C 101.1866028708134,181.26315789473685 202.3732057416268,162.5263157894737 288,149 C 373.6267942583732,135.4736842105263 443.6937799043062,127.15789473684211 532,128 C 620.3062200956938,128.8421052631579 726.8516746411483,138.84210526315786 829,138 C 931.1483253588517,137.15789473684214 1028.8995215311006,125.47368421052633 1130,134 C 1231.1004784688994,142.52631578947367 1335.5502392344497,171.26315789473682 1440,200 C 1440,200 1440,600 1440,600 Z"
                        );
                }

                25% {
                    d: path("M 0,600 C 0,600 0,200 0,200 C 99.92344497607655,185.70334928229664 199.8468899521531,171.4066985645933 286,172 C 372.1531100478469,172.5933014354067 444.53588516746413,188.07655502392345 552,182 C 659.4641148325359,175.92344497607655 802.0095693779906,148.28708133971293 902,143 C 1001.9904306220094,137.71291866028707 1059.4258373205741,154.77511961722487 1142,168 C 1224.5741626794259,181.22488038277513 1332.287081339713,190.61244019138758 1440,200 C 1440,200 1440,600 1440,600 Z"
                        );
                }

                50% {
                    d: path("M 0,600 C 0,600 0,200 0,200 C 70.43062200956936,219.7799043062201 140.86124401913872,239.55980861244018 242,259 C 343.1387559808613,278.4401913875598 474.9856459330143,297.5406698564593 590,261 C 705.0143540669857,224.45933014354065 803.1961722488039,132.27751196172247 883,135 C 962.8038277511961,137.72248803827753 1024.2296650717703,235.34928229665076 1114,262 C 1203.7703349282297,288.65071770334924 1321.8851674641148,244.32535885167462 1440,200 C 1440,200 1440,600 1440,600 Z"
                        );
                }

                75% {
                    d: path("M 0,600 C 0,600 0,200 0,200 C 112.56459330143542,194.77511961722487 225.12918660287085,189.55023923444975 318,190 C 410.87081339712915,190.44976076555025 484.0478468899521,196.57416267942585 574,216 C 663.9521531100479,235.42583732057415 770.6794258373205,268.1531100478469 871,274 C 971.3205741626795,279.8468899521531 1065.2344497607655,258.8133971291866 1159,242 C 1252.7655502392345,225.18660287081337 1346.3827751196172,212.5933014354067 1440,200 C 1440,200 1440,600 1440,600 Z"
                        );
                }

                100% {
                    d: path("M 0,600 C 0,600 0,200 0,200 C 101.1866028708134,181.26315789473685 202.3732057416268,162.5263157894737 288,149 C 373.6267942583732,135.4736842105263 443.6937799043062,127.15789473684211 532,128 C 620.3062200956938,128.8421052631579 726.8516746411483,138.84210526315786 829,138 C 931.1483253588517,137.15789473684214 1028.8995215311006,125.47368421052633 1130,134 C 1231.1004784688994,142.52631578947367 1335.5502392344497,171.26315789473682 1440,200 C 1440,200 1440,600 1440,600 Z"
                        );
                }
            }
        </style>
        <path
            d="M 0,600 C 0,600 0,200 0,200 C 101.1866028708134,181.26315789473685 202.3732057416268,162.5263157894737 288,149 C 373.6267942583732,135.4736842105263 443.6937799043062,127.15789473684211 532,128 C 620.3062200956938,128.8421052631579 726.8516746411483,138.84210526315786 829,138 C 931.1483253588517,137.15789473684214 1028.8995215311006,125.47368421052633 1130,134 C 1231.1004784688994,142.52631578947367 1335.5502392344497,171.26315789473682 1440,200 C 1440,200 1440,600 1440,600 Z"
            stroke="none" stroke-width="0" fill="#4169e1" fill-opacity="0.53"
            class="transition-all duration-300 ease-in-out delay-150 path-0"></path>
        <style>
            .path-1 {
                animation: pathAnim-1 20s;
                animation-timing-function: linear;
                animation-iteration-count: infinite;
            }

            @keyframes pathAnim-1 {
                0% {
                    d: path("M 0,600 C 0,600 0,400 0,400 C 110.21052631578945,401.2918660287081 220.4210526315789,402.5837320574163 322,391 C 423.5789473684211,379.4162679425837 516.5263157894738,354.9569377990431 591,376 C 665.4736842105262,397.0430622009569 721.4736842105265,463.5885167464114 821,469 C 920.5263157894735,474.4114832535886 1063.578947368421,418.688995215311 1174,397 C 1284.421052631579,375.311004784689 1362.2105263157896,387.6555023923445 1440,400 C 1440,400 1440,600 1440,600 Z"
                        );
                }

                25% {
                    d: path("M 0,600 C 0,600 0,400 0,400 C 88.21052631578945,404.3732057416268 176.4210526315789,408.7464114832536 269,398 C 361.5789473684211,387.2535885167464 458.52631578947376,361.3875598086124 569,358 C 679.4736842105262,354.6124401913876 803.4736842105265,373.70334928229664 901,403 C 998.5263157894735,432.29665071770336 1069.578947368421,471.79904306220095 1155,473 C 1240.421052631579,474.20095693779905 1340.2105263157896,437.1004784688995 1440,400 C 1440,400 1440,600 1440,600 Z"
                        );
                }

                50% {
                    d: path("M 0,600 C 0,600 0,400 0,400 C 117.81818181818178,417.48325358851673 235.63636363636357,434.9665071770335 337,449 C 438.36363636363643,463.0334928229665 523.2727272727274,473.6172248803827 597,457 C 670.7272727272726,440.3827751196173 733.2727272727271,396.5645933014354 818,367 C 902.7272727272729,337.4354066985646 1009.6363636363637,322.1244019138756 1117,330 C 1224.3636363636363,337.8755980861244 1332.181818181818,368.9377990430622 1440,400 C 1440,400 1440,600 1440,600 Z"
                        );
                }

                75% {
                    d: path("M 0,600 C 0,600 0,400 0,400 C 93.24401913875596,431.36842105263156 186.48803827751192,462.7368421052632 284,472 C 381.5119617224881,481.2631578947368 483.2918660287082,468.42105263157896 585,442 C 686.7081339712918,415.57894736842104 788.3444976076554,375.578947368421 890,362 C 991.6555023923446,348.421052631579 1093.33014354067,361.2631578947369 1185,372 C 1276.66985645933,382.7368421052631 1358.334928229665,391.36842105263156 1440,400 C 1440,400 1440,600 1440,600 Z"
                        );
                }

                100% {
                    d: path("M 0,600 C 0,600 0,400 0,400 C 110.21052631578945,401.2918660287081 220.4210526315789,402.5837320574163 322,391 C 423.5789473684211,379.4162679425837 516.5263157894738,354.9569377990431 591,376 C 665.4736842105262,397.0430622009569 721.4736842105265,463.5885167464114 821,469 C 920.5263157894735,474.4114832535886 1063.578947368421,418.688995215311 1174,397 C 1284.421052631579,375.311004784689 1362.2105263157896,387.6555023923445 1440,400 C 1440,400 1440,600 1440,600 Z"
                        );
                }
            }
        </style>
        <path
            d="M 0,600 C 0,600 0,400 0,400 C 110.21052631578945,401.2918660287081 220.4210526315789,402.5837320574163 322,391 C 423.5789473684211,379.4162679425837 516.5263157894738,354.9569377990431 591,376 C 665.4736842105262,397.0430622009569 721.4736842105265,463.5885167464114 821,469 C 920.5263157894735,474.4114832535886 1063.578947368421,418.688995215311 1174,397 C 1284.421052631579,375.311004784689 1362.2105263157896,387.6555023923445 1440,400 C 1440,400 1440,600 1440,600 Z"
            stroke="none" stroke-width="0" fill="#4169e1" fill-opacity="1"
            class="transition-all duration-300 ease-in-out delay-150 path-1"></path>
    </svg>
    <main class="container panel align-items-start justify-content-center pt-3 px-3 px-sm-5">
        <h1 class="mb-0">Login to CMS</h1>
        <div class="col-12 justify-content-center">
            <p style="font-size: 0.9rem;">Please login using the login token.</p>
        </div>
        <div class="col-12 d-flex justify-content-center">
            <img src="pad_lock.svg" width="40%">
        </div>
        <form class="mt-5" id="login-form">
            <div class="col-12 text-center">
                <div style="position: relative;">
                    <input type="password" id="token-input" name="token" class=" form-control"
                        placeholder="Enter Token">
                    <div id="loading-spinner" class="lds-dual-ring d-none"
                        style="position: absolute; right: 0; top: -0.3rem">
                    </div>
                </div>
                <div id="form-text" class="form-text text-start d-none"></div>
                <div class="col d-flex mt-3 justify-content-center">
                    <div class="g-recaptcha" data-sitekey="6LeFnvsoAAAAAPd313Ny6hB761wY5fb_Yjn6IJey"></div>
                </div>
            </div>
            <button type="submit" class="btn btn-primary btn-lg" id="login-button"
                style="width: calc(100% - 3rem * 2);; position: absolute; bottom: 2rem; left: ">Login</button>
        </form>
    </main>
    <!-- <script src="../remove_paramters.js"></script> -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        const loginForm = document.getElementById("login-form");
        const formText = document.getElementById("form-text");
        const tokenInput = document.getElementById("token-input");

        loginForm.addEventListener("submit", (e) => {
            e.preventDefault();

            // Check if token was provided
            if (tokenInput.value.length <= 0) {
                formText.innerHTML = "Please provide a token!";
                formText.classList.add('text-danger');
                formText.classList.add('d-block');
                formText.classList.remove('d-none');
                throw new Error("Token not provided");
            }

            // Check if reCAPTCHA was completed
            const captchaResponse = grecaptcha.getResponse();

            if (!captchaResponse.length > 0) {
                formText.innerHTML = "Please complete the reCAPTCHA!";
                formText.classList.add('text-danger');
                formText.classList.add('d-block');
                formText.classList.remove('d-none');
                throw new Error("Captcha not completed");
            }

            const formData = new FormData(e.target);
            const params = new URLSearchParams(formData);

            // Submitting the form
            fetch("validate_token.inc.php", {
                method: "POST",
                headers: {
                    "Content-Type": "application/x-www-form-urlencoded", // Set the correct Content-Type
                },
                body: params, // Serialize the data
            })
                .then((response) => response.json())
                .then((data) => {

                    // if the recaptcha is invalid
                    if (data.recaptcha === false) {
                        window.location.href = "/login/login.php?status=57";
                    }

                    if (data.valid === false) {
                        // if the token is invalid
                        window.location.href = "/login/login.php?status=56";
                    } else {
                        // if the token is valid
                        window.location.href = "/dashboard/customer.php";
                    }
                })
                .catch((error) => console.error("Error:", error));
        });
    </script>
</body>

</html>