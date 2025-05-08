<?php
    $albumImageLink = 'https://upload.wikimedia.org/wikipedia/en/thumb/c/cd/Ed_Sheeran_-_Equals.png/250px-Ed_Sheeran_-_Equals.png';
?>

<x-layout :links="[
    'https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200&icon_names=play_arrow,replay,skip_previous']">

    <script src="https://w.soundcloud.com/player/api.js" type="text/javascript"></script>

    <div id="menu" class="m-auto justify-center">

        <h1 class="text-6xl font-bold text-center">Guess the song in the shortest time</h1>

        <div class="mt-20 flex flex-col gap-10 justify-center items-center sm:items-baseline sm:flex-row">

            <div id="ready_button_wrapper" class="w-min">
                <button id="ready_button" class="w-50 text-white text-3xl bg-pink px-6 py-3 rounded-lg hover:bg-pink-300 hover:cursor-pointer duration-200">
                    Daily
                </button>
            </div>

            <div id="ready_button_wrapper" class="w-min">
                <button id="unlimited_button" class="w-50 text-white text-3xl bg-pink px-6 py-3 rounded-lg hover:bg-pink-300 hover:cursor-pointer duration-200">
                    Unlimited
                </button>
            </div>

        </div>

    </div>

    <div id="game_container" class="hidden relative flex flex-col flex-1">

        <div id="game_end_widget" class="hidden absolute flex flex-col items-center bg-white w-[320px] h-min border rounded-xl z-20 right-[50%] translate-x-[50%] py-10 px-6 duration-1000">

            <h2 class="text-5xl font-bold">Game Over</h2>

            <img id="game_widget" src="" alt="">

            <div id="game_overall_score" class="mt-6 flex text-3xl font-bold">
                <p id="game_widget_score"></p>
                <p>/10000</p>
            </div>

            <div class="w-full flex flex-col">

                <div class="mt-5">

                    <div class="flex justify-between text-xl">

                        <div class="flex">

                            <p id="game_song_score_1"></p>
                            <p>/3000</p>

                        </div>

                    </div>

                    <div class="relative w-full h-2">

                        <div class="absolute w-full h-2 rounded bg-gray-200"></div>
                        <div id="game_song_bar_1" class="absolute w-[0%] h-2 rounded bg-pink"></div>

                    </div>

                </div>

                <div class="relative rounded-2xl w-full">

                    <a id="soundcloud_card_link_1" href="" target="_blank">

                        <div id="soundcloud_card_1" class="relative border-2 border-gray-400 flex justify-between px-3 py-2 px-5 rounded-xl flex gap-2 items-center w-full mt-3 overflow-hidden">

                            <img id="soundcloud_card_image_1" src="" class="absolute left-0 -z-10 duration-1000"
                                alt="{{ Vite::asset('resources/images/album_cover_placeholder.png') }}"
                            >

                            <div class="flex flex-col justify-end py-1 backdrop-blur-sm">

                                <p id="soundcloud_card_artist_1" class="text-l text-white text-shadow-lg"></p>
                                <p id="soundcloud_card_title_1" class="text-xl/5 font-bold text-white text-shadow-xs"></p>

                            </div>

                            <div id="soundcloud_logo_1" class="p-2 bg-orange-500 rounded-full w-max h-min">
                                <svg class="w-8 h-8 fill-white" viewBox="0 0 143 64" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                    <path  transform="translate(-166.000000, -1125.000000)" d="M308.984235,1169.99251 C308.382505,1180.70295 299.444837,1189.03525 288.718543,1188.88554 L240.008437,1188.88554 C237.777524,1188.86472 235.977065,1187.05577 235.966737,1184.82478 L235.966737,1132.37801 C235.894282,1130.53582 236.962478,1128.83883 238.654849,1128.10753 C238.654849,1128.10753 243.135035,1124.99996 252.572022,1124.99996 C258.337036,1124.99309 263.996267,1126.54789 268.948531,1129.49925 C276.76341,1134.09703 282.29495,1141.75821 284.200228,1150.62285 C285.880958,1150.14737 287.620063,1149.90993 289.36674,1149.91746 C294.659738,1149.88414 299.738952,1152.0036 303.438351,1155.78928 C307.13775,1159.57496 309.139562,1164.70168 308.984235,1169.99251 Z M229.885123,1135.69525 C231.353099,1153.48254 232.420718,1169.70654 229.885123,1187.43663 C229.796699,1188.23857 229.119091,1188.84557 228.312292,1188.84557 C227.505494,1188.84557 226.827885,1188.23857 226.739461,1187.43663 C224.375448,1169.85905 225.404938,1153.33003 226.739461,1135.69525 C226.672943,1135.09199 226.957336,1134.50383 227.471487,1134.18133 C227.985639,1133.85884 228.638946,1133.85884 229.153097,1134.18133 C229.667248,1134.50383 229.951641,1135.09199 229.885123,1135.69525 Z M220.028715,1187.4557 C219.904865,1188.26549 219.208361,1188.86356 218.389157,1188.86356 C217.569953,1188.86356 216.87345,1188.26549 216.7496,1187.4557 C214.986145,1172.28686 214.986145,1156.96477 216.7496,1141.79593 C216.840309,1140.9535 217.551388,1140.31488 218.398689,1140.31488 C219.245991,1140.31488 219.95707,1140.9535 220.047779,1141.79593 C222.005153,1156.95333 221.998746,1172.29994 220.028715,1187.4557 Z M210.153241,1140.2517 C211.754669,1156.55195 212.479125,1171.15545 210.134176,1187.41757 C210.134176,1188.29148 209.425728,1188.99993 208.551813,1188.99993 C207.677898,1188.99993 206.969449,1188.29148 206.969449,1187.41757 C204.70076,1171.36516 205.463344,1156.34224 206.969449,1140.2517 C207.05845,1139.43964 207.744425,1138.82474 208.561345,1138.82474 C209.378266,1138.82474 210.06424,1139.43964 210.153241,1140.2517 Z M200.258703,1187.47476 C200.169129,1188.29694 199.474788,1188.91975 198.647742,1188.91975 C197.820697,1188.91975 197.126356,1188.29694 197.036782,1187.47476 C195.216051,1173.32359 195.216051,1158.99744 197.036782,1144.84627 C197.036782,1143.94077 197.770837,1143.20671 198.676339,1143.20671 C199.581842,1143.20671 200.315897,1143.94077 200.315897,1144.84627 C202.251054,1158.99121 202.231809,1173.33507 200.258703,1187.47476 Z M190.383229,1155.50339 C192.880695,1166.56087 191.755882,1176.32196 190.287906,1187.58915 C190.168936,1188.33924 189.522207,1188.89148 188.762737,1188.89148 C188.003266,1188.89148 187.356537,1188.33924 187.237567,1187.58915 C185.903044,1176.47448 184.797296,1166.48462 187.142244,1155.50339 C187.142244,1154.60842 187.867763,1153.8829 188.762737,1153.8829 C189.65771,1153.8829 190.383229,1154.60842 190.383229,1155.50339 Z M180.526821,1153.82571 C182.814575,1165.15009 182.071055,1174.7396 180.469627,1186.10211 C180.27898,1187.7798 177.400223,1187.79886 177.247706,1186.10211 C175.798795,1174.91118 175.112468,1165.0357 177.190512,1153.82571 C177.281785,1152.97315 178.001234,1152.32661 178.858666,1152.32661 C179.716099,1152.32661 180.435548,1152.97315 180.526821,1153.82571 Z M170.575089,1159.31632 C172.977231,1166.82778 172.157452,1172.92846 170.479765,1180.63056 C170.391921,1181.42239 169.722678,1182.02149 168.925999,1182.02149 C168.12932,1182.02149 167.460077,1181.42239 167.372232,1180.63056 C165.923321,1173.08097 165.332318,1166.84684 167.23878,1159.31632 C167.330053,1158.46376 168.049502,1157.81722 168.906934,1157.81722 C169.764367,1157.81722 170.483816,1158.46376 170.575089,1159.31632 Z"></path>
                                </svg>
                            </div>

                        </div>
                    </a>

                </div>

                <div class="mt-5">

                    <div class="flex justify-between text-xl">

                        <div class="flex">

                            <p id="game_song_score_2"></p>
                            <p>/3000</p>

                        </div>

                    </div>

                    <div class="relative w-full h-2">

                        <div class="absolute w-full h-2 rounded bg-gray-200"></div>
                        <div id="game_song_bar_2" class="absolute w-[0%] h-2 rounded bg-pink"></div>

                    </div>

                </div>

                <div class="relative rounded-2xl w-full">

                    <a id="soundcloud_card_link_2" href="" target="_blank">

                        <div id="soundcloud_card_2" class="relative border-2 border-gray-400 flex justify-between px-3 py-2 px-5 rounded-xl flex gap-2 items-center w-full mt-3 overflow-hidden">

                            <img id="soundcloud_card_image_2" src="" class="absolute left-0 -z-10 duration-1000"
                                alt="{{ Vite::asset('resources/images/album_cover_placeholder.png') }}"
                            >

                            <div class="flex flex-col justify-end py-1 backdrop-blur-sm">

                                <p id="soundcloud_card_artist_2" class="text-l text-white text-shadow-lg"></p>
                                <p id="soundcloud_card_title_2" class="text-xl/5 font-bold text-white text-shadow-xs"></p>

                            </div>

                            <div id="soundcloud_logo_2" class="p-2 bg-orange-500 rounded-full w-max h-min">
                                <svg class="w-8 h-8 fill-white" viewBox="0 0 143 64" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                    <path  transform="translate(-166.000000, -1125.000000)" d="M308.984235,1169.99251 C308.382505,1180.70295 299.444837,1189.03525 288.718543,1188.88554 L240.008437,1188.88554 C237.777524,1188.86472 235.977065,1187.05577 235.966737,1184.82478 L235.966737,1132.37801 C235.894282,1130.53582 236.962478,1128.83883 238.654849,1128.10753 C238.654849,1128.10753 243.135035,1124.99996 252.572022,1124.99996 C258.337036,1124.99309 263.996267,1126.54789 268.948531,1129.49925 C276.76341,1134.09703 282.29495,1141.75821 284.200228,1150.62285 C285.880958,1150.14737 287.620063,1149.90993 289.36674,1149.91746 C294.659738,1149.88414 299.738952,1152.0036 303.438351,1155.78928 C307.13775,1159.57496 309.139562,1164.70168 308.984235,1169.99251 Z M229.885123,1135.69525 C231.353099,1153.48254 232.420718,1169.70654 229.885123,1187.43663 C229.796699,1188.23857 229.119091,1188.84557 228.312292,1188.84557 C227.505494,1188.84557 226.827885,1188.23857 226.739461,1187.43663 C224.375448,1169.85905 225.404938,1153.33003 226.739461,1135.69525 C226.672943,1135.09199 226.957336,1134.50383 227.471487,1134.18133 C227.985639,1133.85884 228.638946,1133.85884 229.153097,1134.18133 C229.667248,1134.50383 229.951641,1135.09199 229.885123,1135.69525 Z M220.028715,1187.4557 C219.904865,1188.26549 219.208361,1188.86356 218.389157,1188.86356 C217.569953,1188.86356 216.87345,1188.26549 216.7496,1187.4557 C214.986145,1172.28686 214.986145,1156.96477 216.7496,1141.79593 C216.840309,1140.9535 217.551388,1140.31488 218.398689,1140.31488 C219.245991,1140.31488 219.95707,1140.9535 220.047779,1141.79593 C222.005153,1156.95333 221.998746,1172.29994 220.028715,1187.4557 Z M210.153241,1140.2517 C211.754669,1156.55195 212.479125,1171.15545 210.134176,1187.41757 C210.134176,1188.29148 209.425728,1188.99993 208.551813,1188.99993 C207.677898,1188.99993 206.969449,1188.29148 206.969449,1187.41757 C204.70076,1171.36516 205.463344,1156.34224 206.969449,1140.2517 C207.05845,1139.43964 207.744425,1138.82474 208.561345,1138.82474 C209.378266,1138.82474 210.06424,1139.43964 210.153241,1140.2517 Z M200.258703,1187.47476 C200.169129,1188.29694 199.474788,1188.91975 198.647742,1188.91975 C197.820697,1188.91975 197.126356,1188.29694 197.036782,1187.47476 C195.216051,1173.32359 195.216051,1158.99744 197.036782,1144.84627 C197.036782,1143.94077 197.770837,1143.20671 198.676339,1143.20671 C199.581842,1143.20671 200.315897,1143.94077 200.315897,1144.84627 C202.251054,1158.99121 202.231809,1173.33507 200.258703,1187.47476 Z M190.383229,1155.50339 C192.880695,1166.56087 191.755882,1176.32196 190.287906,1187.58915 C190.168936,1188.33924 189.522207,1188.89148 188.762737,1188.89148 C188.003266,1188.89148 187.356537,1188.33924 187.237567,1187.58915 C185.903044,1176.47448 184.797296,1166.48462 187.142244,1155.50339 C187.142244,1154.60842 187.867763,1153.8829 188.762737,1153.8829 C189.65771,1153.8829 190.383229,1154.60842 190.383229,1155.50339 Z M180.526821,1153.82571 C182.814575,1165.15009 182.071055,1174.7396 180.469627,1186.10211 C180.27898,1187.7798 177.400223,1187.79886 177.247706,1186.10211 C175.798795,1174.91118 175.112468,1165.0357 177.190512,1153.82571 C177.281785,1152.97315 178.001234,1152.32661 178.858666,1152.32661 C179.716099,1152.32661 180.435548,1152.97315 180.526821,1153.82571 Z M170.575089,1159.31632 C172.977231,1166.82778 172.157452,1172.92846 170.479765,1180.63056 C170.391921,1181.42239 169.722678,1182.02149 168.925999,1182.02149 C168.12932,1182.02149 167.460077,1181.42239 167.372232,1180.63056 C165.923321,1173.08097 165.332318,1166.84684 167.23878,1159.31632 C167.330053,1158.46376 168.049502,1157.81722 168.906934,1157.81722 C169.764367,1157.81722 170.483816,1158.46376 170.575089,1159.31632 Z"></path>
                                </svg>
                            </div>

                        </div>

                    </a>

                </div>

                <div class="mt-5">

                    <div class="flex justify-between text-xl">

                        <div class="flex">

                            <p id="game_song_score_3"></p>
                            <p>/3000</p>

                        </div>

                    </div>

                    <div class="relative w-full h-2">

                        <div class="absolute w-full h-2 rounded bg-gray-200"></div>
                        <div id="game_song_bar_3" class="absolute w-[0%] h-2 rounded bg-pink"></div>

                    </div>

                </div>

                <div class="relative rounded-2xl w-full mb-6">

                    <a id="soundcloud_card_link_3" href="" target="_blank">

                        <div id="soundcloud_card_3" class="relative border-2 border-gray-400 flex justify-between px-3 py-2 px-5 rounded-xl flex gap-2 items-center w-full mt-3 overflow-hidden">

                            <img id="soundcloud_card_image_3" src="" class="absolute left-0 -z-10 duration-1000"
                                alt="{{ Vite::asset('resources/images/album_cover_placeholder.png') }}"
                            >

                            <div class="flex flex-col justify-end py-1 backdrop-blur-sm">

                                <p id="soundcloud_card_artist_3" class="text-l text-white text-shadow-lg"></p>
                                <p id="soundcloud_card_title_3" class="text-xl/5 font-bold text-white text-shadow-xs"></p>

                            </div>

                            <div id="soundcloud_logo_3" class="p-2 bg-orange-500 rounded-full w-max h-min">
                                <svg class="w-8 h-8 fill-white" viewBox="0 0 143 64" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                    <path  transform="translate(-166.000000, -1125.000000)" d="M308.984235,1169.99251 C308.382505,1180.70295 299.444837,1189.03525 288.718543,1188.88554 L240.008437,1188.88554 C237.777524,1188.86472 235.977065,1187.05577 235.966737,1184.82478 L235.966737,1132.37801 C235.894282,1130.53582 236.962478,1128.83883 238.654849,1128.10753 C238.654849,1128.10753 243.135035,1124.99996 252.572022,1124.99996 C258.337036,1124.99309 263.996267,1126.54789 268.948531,1129.49925 C276.76341,1134.09703 282.29495,1141.75821 284.200228,1150.62285 C285.880958,1150.14737 287.620063,1149.90993 289.36674,1149.91746 C294.659738,1149.88414 299.738952,1152.0036 303.438351,1155.78928 C307.13775,1159.57496 309.139562,1164.70168 308.984235,1169.99251 Z M229.885123,1135.69525 C231.353099,1153.48254 232.420718,1169.70654 229.885123,1187.43663 C229.796699,1188.23857 229.119091,1188.84557 228.312292,1188.84557 C227.505494,1188.84557 226.827885,1188.23857 226.739461,1187.43663 C224.375448,1169.85905 225.404938,1153.33003 226.739461,1135.69525 C226.672943,1135.09199 226.957336,1134.50383 227.471487,1134.18133 C227.985639,1133.85884 228.638946,1133.85884 229.153097,1134.18133 C229.667248,1134.50383 229.951641,1135.09199 229.885123,1135.69525 Z M220.028715,1187.4557 C219.904865,1188.26549 219.208361,1188.86356 218.389157,1188.86356 C217.569953,1188.86356 216.87345,1188.26549 216.7496,1187.4557 C214.986145,1172.28686 214.986145,1156.96477 216.7496,1141.79593 C216.840309,1140.9535 217.551388,1140.31488 218.398689,1140.31488 C219.245991,1140.31488 219.95707,1140.9535 220.047779,1141.79593 C222.005153,1156.95333 221.998746,1172.29994 220.028715,1187.4557 Z M210.153241,1140.2517 C211.754669,1156.55195 212.479125,1171.15545 210.134176,1187.41757 C210.134176,1188.29148 209.425728,1188.99993 208.551813,1188.99993 C207.677898,1188.99993 206.969449,1188.29148 206.969449,1187.41757 C204.70076,1171.36516 205.463344,1156.34224 206.969449,1140.2517 C207.05845,1139.43964 207.744425,1138.82474 208.561345,1138.82474 C209.378266,1138.82474 210.06424,1139.43964 210.153241,1140.2517 Z M200.258703,1187.47476 C200.169129,1188.29694 199.474788,1188.91975 198.647742,1188.91975 C197.820697,1188.91975 197.126356,1188.29694 197.036782,1187.47476 C195.216051,1173.32359 195.216051,1158.99744 197.036782,1144.84627 C197.036782,1143.94077 197.770837,1143.20671 198.676339,1143.20671 C199.581842,1143.20671 200.315897,1143.94077 200.315897,1144.84627 C202.251054,1158.99121 202.231809,1173.33507 200.258703,1187.47476 Z M190.383229,1155.50339 C192.880695,1166.56087 191.755882,1176.32196 190.287906,1187.58915 C190.168936,1188.33924 189.522207,1188.89148 188.762737,1188.89148 C188.003266,1188.89148 187.356537,1188.33924 187.237567,1187.58915 C185.903044,1176.47448 184.797296,1166.48462 187.142244,1155.50339 C187.142244,1154.60842 187.867763,1153.8829 188.762737,1153.8829 C189.65771,1153.8829 190.383229,1154.60842 190.383229,1155.50339 Z M180.526821,1153.82571 C182.814575,1165.15009 182.071055,1174.7396 180.469627,1186.10211 C180.27898,1187.7798 177.400223,1187.79886 177.247706,1186.10211 C175.798795,1174.91118 175.112468,1165.0357 177.190512,1153.82571 C177.281785,1152.97315 178.001234,1152.32661 178.858666,1152.32661 C179.716099,1152.32661 180.435548,1152.97315 180.526821,1153.82571 Z M170.575089,1159.31632 C172.977231,1166.82778 172.157452,1172.92846 170.479765,1180.63056 C170.391921,1181.42239 169.722678,1182.02149 168.925999,1182.02149 C168.12932,1182.02149 167.460077,1181.42239 167.372232,1180.63056 C165.923321,1173.08097 165.332318,1166.84684 167.23878,1159.31632 C167.330053,1158.46376 168.049502,1157.81722 168.906934,1157.81722 C169.764367,1157.81722 170.483816,1158.46376 170.575089,1159.31632 Z"></path>
                                </svg>
                            </div>

                        </div>

                    </a>

                </div>

                <p id="accuracy_bonus" class="hidden text-xl text-bold text-center">+ 1000 accuracy bonus</p>
            </div>

            <div class="mt-auto">
                <button id="end_game_button" class="text-white text-2xl bg-pink px-6 py-3 rounded-lg hover:bg-pink-300 hover:cursor-pointer duration-200">
                    Ok
                </button>
            </div>

        </div>

        <div class="relative flex-col mx-auto items-center">


            <div id="game_card" class="py-10 px-10 w-[320px] h-[390px] bg-white rounded-xl border drop-shadow-xl/25 duration-1000">

                <h2 id="round_title" class="hidden mb-5 text-5xl font-bold">Correct!</h2>
                <p id="round_song_score" class="hidden text-2xl text-center">You guessed the song in 15.32s</p>

                <div class="relative rounded-2xl w-full">

                    <div class="relative m-auto w-inherit translate-x-[50%]">
                        <img id="vinyl_loader" class="absolute translate-x-[-50%] w-[220px] h-[220px] animate-spin" src="{{ Vite::asset('resources/images/vinyl_record_svg.svg') }}" alt="">
                    </div>

                    <a id="unlimited_soundcloud_card_link" href="" target="_blank">

                        <div id="album_image_container" class="h-[220px] overflow-hidden rounded-xl blur-[40px]">

                            <img id="main_album_cover" src="" class="opacity-0 duration-1000"
                            alt="{{ Vite::asset('resources/images/album_cover_placeholder.png') }}"
                            >

                            <div class="flex flex-col justify-end py-1 backdrop-blur-sm">

                                <p id="round_song_artist" class="text-l text-white text-shadow-lg"></p>
                                <p id="round_song_title" class="text-xl/5 font-bold text-white text-shadow-xs"></p>

                            </div>

                            <div id="soundcloud_logo" class="hidden p-2 bg-orange-500 rounded-full w-max h-min">
                                <svg class="w-8 h-8 fill-white" viewBox="0 0 143 64" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                    <path  transform="translate(-166.000000, -1125.000000)" d="M308.984235,1169.99251 C308.382505,1180.70295 299.444837,1189.03525 288.718543,1188.88554 L240.008437,1188.88554 C237.777524,1188.86472 235.977065,1187.05577 235.966737,1184.82478 L235.966737,1132.37801 C235.894282,1130.53582 236.962478,1128.83883 238.654849,1128.10753 C238.654849,1128.10753 243.135035,1124.99996 252.572022,1124.99996 C258.337036,1124.99309 263.996267,1126.54789 268.948531,1129.49925 C276.76341,1134.09703 282.29495,1141.75821 284.200228,1150.62285 C285.880958,1150.14737 287.620063,1149.90993 289.36674,1149.91746 C294.659738,1149.88414 299.738952,1152.0036 303.438351,1155.78928 C307.13775,1159.57496 309.139562,1164.70168 308.984235,1169.99251 Z M229.885123,1135.69525 C231.353099,1153.48254 232.420718,1169.70654 229.885123,1187.43663 C229.796699,1188.23857 229.119091,1188.84557 228.312292,1188.84557 C227.505494,1188.84557 226.827885,1188.23857 226.739461,1187.43663 C224.375448,1169.85905 225.404938,1153.33003 226.739461,1135.69525 C226.672943,1135.09199 226.957336,1134.50383 227.471487,1134.18133 C227.985639,1133.85884 228.638946,1133.85884 229.153097,1134.18133 C229.667248,1134.50383 229.951641,1135.09199 229.885123,1135.69525 Z M220.028715,1187.4557 C219.904865,1188.26549 219.208361,1188.86356 218.389157,1188.86356 C217.569953,1188.86356 216.87345,1188.26549 216.7496,1187.4557 C214.986145,1172.28686 214.986145,1156.96477 216.7496,1141.79593 C216.840309,1140.9535 217.551388,1140.31488 218.398689,1140.31488 C219.245991,1140.31488 219.95707,1140.9535 220.047779,1141.79593 C222.005153,1156.95333 221.998746,1172.29994 220.028715,1187.4557 Z M210.153241,1140.2517 C211.754669,1156.55195 212.479125,1171.15545 210.134176,1187.41757 C210.134176,1188.29148 209.425728,1188.99993 208.551813,1188.99993 C207.677898,1188.99993 206.969449,1188.29148 206.969449,1187.41757 C204.70076,1171.36516 205.463344,1156.34224 206.969449,1140.2517 C207.05845,1139.43964 207.744425,1138.82474 208.561345,1138.82474 C209.378266,1138.82474 210.06424,1139.43964 210.153241,1140.2517 Z M200.258703,1187.47476 C200.169129,1188.29694 199.474788,1188.91975 198.647742,1188.91975 C197.820697,1188.91975 197.126356,1188.29694 197.036782,1187.47476 C195.216051,1173.32359 195.216051,1158.99744 197.036782,1144.84627 C197.036782,1143.94077 197.770837,1143.20671 198.676339,1143.20671 C199.581842,1143.20671 200.315897,1143.94077 200.315897,1144.84627 C202.251054,1158.99121 202.231809,1173.33507 200.258703,1187.47476 Z M190.383229,1155.50339 C192.880695,1166.56087 191.755882,1176.32196 190.287906,1187.58915 C190.168936,1188.33924 189.522207,1188.89148 188.762737,1188.89148 C188.003266,1188.89148 187.356537,1188.33924 187.237567,1187.58915 C185.903044,1176.47448 184.797296,1166.48462 187.142244,1155.50339 C187.142244,1154.60842 187.867763,1153.8829 188.762737,1153.8829 C189.65771,1153.8829 190.383229,1154.60842 190.383229,1155.50339 Z M180.526821,1153.82571 C182.814575,1165.15009 182.071055,1174.7396 180.469627,1186.10211 C180.27898,1187.7798 177.400223,1187.79886 177.247706,1186.10211 C175.798795,1174.91118 175.112468,1165.0357 177.190512,1153.82571 C177.281785,1152.97315 178.001234,1152.32661 178.858666,1152.32661 C179.716099,1152.32661 180.435548,1152.97315 180.526821,1153.82571 Z M170.575089,1159.31632 C172.977231,1166.82778 172.157452,1172.92846 170.479765,1180.63056 C170.391921,1181.42239 169.722678,1182.02149 168.925999,1182.02149 C168.12932,1182.02149 167.460077,1181.42239 167.372232,1180.63056 C165.923321,1173.08097 165.332318,1166.84684 167.23878,1159.31632 C167.330053,1158.46376 168.049502,1157.81722 168.906934,1157.81722 C169.764367,1157.81722 170.483816,1158.46376 170.575089,1159.31632 Z"></path>
                                </svg>
                            </div>

                        </div>

                    </a>
                </div>

                <div id="playback_button_wrapper" class="mt-8 px-3 flex justify-between items-center">

                    <x-circle-button id="skip_start_button" class="w-[50px] h-[50px] bg-white hover:bg-pink hover:fill-white hover:cursor-pointer duration-200">
                        <svg class="w-6 h-6 my-auto rotate-180" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512"><!--!Font Awesome Free 6.7.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.--><path d="M52.5 440.6c-9.5 7.9-22.8 9.7-34.1 4.4S0 428.4 0 416L0 96C0 83.6 7.2 72.3 18.4 67s24.5-3.6 34.1 4.4l192 160L256 241l0-145c0-17.7 14.3-32 32-32s32 14.3 32 32l0 320c0 17.7-14.3 32-32 32s-32-14.3-32-32l0-145-11.5 9.6-192 160z"/></svg>
                    </x-circle-button>

                    <x-circle-button id="play_pause_button" class="w-[70px] h-[70px] bg-gray-300 hover:cursor-pointer duration-200">
                        <svg id="play_icon" class="h-6 w-6 my-auto pl-1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512"><!--!Font Awesome Free 6.7.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.--><path d="M73 39c-14.8-9.1-33.4-9.4-48.5-.9S0 62.6 0 80L0 432c0 17.4 9.4 33.4 24.5 41.9s33.7 8.1 48.5-.9L361 297c14.3-8.7 23-24.2 23-41s-8.7-32.2-23-41L73 39z"/></svg>
                        <svg id="pause_icon" class="hidden h-6 w-6 my-auto" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512"><!--!Font Awesome Free 6.7.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.--><path d="M48 64C21.5 64 0 85.5 0 112L0 400c0 26.5 21.5 48 48 48l32 0c26.5 0 48-21.5 48-48l0-288c0-26.5-21.5-48-48-48L48 64zm192 0c-26.5 0-48 21.5-48 48l0 288c0 26.5 21.5 48 48 48l32 0c26.5 0 48-21.5 48-48l0-288c0-26.5-21.5-48-48-48l-32 0z"/></svg>
                    </x-circle-button>

                    <x-circle-button id="locked_button" class="w-[50px] h-[50px] bg-white hover:bg-pink hover:fill-white hover:cursor-pointer duration-200">
                        <svg id="unlocked_icon" class="h-6 w-6 my-auto pl-1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512"><!--!Font Awesome Free 6.7.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.--><path d="M352 144c0-44.2 35.8-80 80-80s80 35.8 80 80l0 48c0 17.7 14.3 32 32 32s32-14.3 32-32l0-48C576 64.5 511.5 0 432 0S288 64.5 288 144l0 48L64 192c-35.3 0-64 28.7-64 64L0 448c0 35.3 28.7 64 64 64l320 0c35.3 0 64-28.7 64-64l0-192c0-35.3-28.7-64-64-64l-32 0 0-48z"/></svg>
                        <svg id="locked_icon" class="hidden h-6 w-6 my-auto pl-1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><!--!Font Awesome Free 6.7.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.--><path d="M144 144l0 48 160 0 0-48c0-44.2-35.8-80-80-80s-80 35.8-80 80zM80 192l0-48C80 64.5 144.5 0 224 0s144 64.5 144 144l0 48 16 0c35.3 0 64 28.7 64 64l0 192c0 35.3-28.7 64-64 64L64 512c-35.3 0-64-28.7-64-64L0 256c0-35.3 28.7-64 64-64l16 0z"/></svg>
                    </x-circle-button>

                </div>

                <div id="next_round_button_container" class="hidden mt-10">

                    <button id="next_round_button" class="text-white text-2xl bg-pink px-6 py-3 rounded-lg hover:bg-pink-300 hover:cursor-pointer duration-200">
                        Next Round
                    </button>

                </div>

            </div>

            <div class="flex justify-between">

                <div class="static bottom-0 sm:absolute flex flex-col justify-between items-end mt-4 sm:h-[390px] sm:top-0 sm:left-0 sm:translate-x-[-100%] sm:pb-4 sm:pr-5">

                    <div id="song_number_container" class="hidden flex h-min gap-2">

                        <p class="hidden sm:block">Song:</p>
                        <p class="hidden sm:block" id="song_number">1/3</p>

                    </div>

                    <div class="flex h-min mt-auto gap-2">
                        <p>Score:</p>
                        <p id="score">3000</p>
                    </div>

                </div>

                <div class="static sm:absolute flex flex-col justify-between mt-4 sm:h-[390px] sm:top-0 sm:right-0 sm:translate-x-[100%] sm:pb-4 sm:pl-5">

                    <div class="hidden sm:flex right-0 top-0 ">

                        <div id="mute_button_container" class="relative w-8 h-8">

                            <svg id="volume_icon" class="absolute w-8 h-8 hover:cursor-pointer" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 512">
                                <!--!Font Awesome Free 6.7.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.-->
                                <path d="M533.6 32.5C598.5 85.2 640 165.8 640 256s-41.5 170.7-106.4 223.5c-10.3 8.4-25.4 6.8-33.8-3.5s-6.8-25.4 3.5-33.8C557.5 398.2 592 331.2 592 256s-34.5-142.2-88.7-186.3c-10.3-8.4-11.8-23.5-3.5-33.8s23.5-11.8 33.8-3.5zM473.1 107c43.2 35.2 70.9 88.9 70.9 149s-27.7 113.8-70.9 149c-10.3 8.4-25.4 6.8-33.8-3.5s-6.8-25.4 3.5-33.8C475.3 341.3 496 301.1 496 256s-20.7-85.3-53.2-111.8c-10.3-8.4-11.8-23.5-3.5-33.8s23.5-11.8 33.8-3.5zm-60.5 74.5C434.1 199.1 448 225.9 448 256s-13.9 56.9-35.4 74.5c-10.3 8.4-25.4 6.8-33.8-3.5s-6.8-25.4 3.5-33.8C393.1 284.4 400 271 400 256s-6.9-28.4-17.7-37.3c-10.3-8.4-11.8-23.5-3.5-33.8s23.5-11.8 33.8-3.5zM301.1 34.8C312.6 40 320 51.4 320 64l0 384c0 12.6-7.4 24-18.9 29.2s-25 3.1-34.4-5.3L131.8 352 64 352c-35.3 0-64-28.7-64-64l0-64c0-35.3 28.7-64 64-64l67.8 0L266.7 40.1c9.4-8.4 22.9-10.4 34.4-5.3z"/>
                            </svg>

                            <svg id="mute_icon" class="absolute hidden" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512">
                                <!--!Font Awesome Free 6.7.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.-->
                                <path d="M301.1 34.8C312.6 40 320 51.4 320 64l0 384c0 12.6-7.4 24-18.9 29.2s-25 3.1-34.4-5.3L131.8 352 64 352c-35.3 0-64-28.7-64-64l0-64c0-35.3 28.7-64 64-64l67.8 0L266.7 40.1c9.4-8.4 22.9-10.4 34.4-5.3zM425 167l55 55 55-55c9.4-9.4 24.6-9.4 33.9 0s9.4 24.6 0 33.9l-55 55 55 55c9.4 9.4 9.4 24.6 0 33.9s-24.6 9.4-33.9 0l-55-55-55 55c-9.4 9.4-24.6 9.4-33.9 0s-9.4-24.6 0-33.9l55-55-55-55c-9.4-9.4-9.4-24.6 0-33.9s24.6-9.4 33.9 0z"/>
                            </svg>

                        </div>

                        <div>

                            <div class="relative translate-x-[-50%]">

                                <div class="w-8 h-8"></div>
                                <input id="volume_slider" class="absolute accent-pink rotate-270 translate-x-[-50%] translate-y-[50%] mt-15 mt-5 hover:cursor-pointer" type="range" orient="vertical" min="0" max="100"  step="1">

                            </div>

                        </div>

                    </div>

                    <div class="flex h-min mt-auto gap-2">
                        <p>Lives:</p>
                        <p id="lives">3/3</p>
                    </div>

                </div>

            </div>

        </div>

        <div class="mx-5">

            <div id="playback_bar_container" class="relative mt-18 h-[1px] max-w-[900px] w-full mx-auto">

                <div class="bg-pink h-[5px] max-w-[900px] w-full absolute mr-1"></div>
                <div id="revealed_bar" class="bg-gray-300 h-[5px] w-[0px] absolute"></div>
                <div id="played_bar" class="bg-gray-600 h-[5px] w-[0px] absolute"></div>

                <x-circle-button id="slider_button" class="w-[27px] h-[27px] top-[2px] bg-white translate-x-[-50%] translate-y-[-50%] absolute hover:w-[32px] hover:h-[32px] hover:cursor-pointer" style="left: 0px"></x-circle-button>

            </div>

        </div>

        <div class="flex justify-center flex-1">

            <div class="relative flex flex-col mt-auto mb-8 flex-1 max-w-[1000px] mx-1">

                <div id="autocomplete_container" class="absolute bottom-full bg-white text-xl border border-b-0 w-full z-10 hidden">

                    <div id="autocomplete_results" class="hidden">

                    </div>

                    <div id="placeholder_autocomplete_inputs" class="hover:cursor-progress hidden">

                        <x-suggested-song-placeholder>w</x-suggested-song-placeholder>
                        <x-suggested-song-placeholder>w</x-suggested-song-placeholder>
                        <x-suggested-song-placeholder>w</x-suggested-song-placeholder>
                        <x-suggested-song-placeholder>w</x-suggested-song-placeholder>
                        <x-suggested-song-placeholder>w</x-suggested-song-placeholder>
                        <x-suggested-song-placeholder>w</x-suggested-song-placeholder>
                        <x-suggested-song-placeholder>w</x-suggested-song-placeholder>
                        <x-suggested-song-placeholder>w</x-suggested-song-placeholder>


                    </div>

                    <div id="loader_container" class="absolute w-full flex justify-center top-[50%] translate-y-[-50%] hidden">

                        <svg aria-hidden="true" class="inline w-16 h-16 text-gray-200 animate-spin dark:text-gray-600 fill-pink" viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z" fill="currentColor"/>
                            <path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z" fill="currentFill"/>
                        </svg>

                    </div>


                </div>

                <div class="relative p-[1px]">
                    <input id="guess_input" class="w-full bg-white h-[60px] border px-5 text-xl" placeholder="Guess a song" type="text" />
                    <div id="guess_input_container" class="absolute w-full h-full top-0 left-0 border border-red-500 opacity-0 -z-10"></div>
                </div>

                <div class="mx-auto mt-4">

                    <button id="guess_button" class="text-white text-2xl bg-pink px-6 py-3 rounded-lg w-min hover:bg-pink-300 hover:cursor-pointer duration-200">
                        Guess
                    </button>
                </div>

            </div>

        </div>

        <div class="absolute left-0 top-0 blur-[300px] translate-x-[-90%] translate-y-[-50%] -z-10">
            <img id="left_album_cover" class="w-175 opacity-0 duration-1000" src=""
            alt="{{ Vite::asset('resources/images/album_cover_placeholder.png') }}"
            >
        </div>

        <div class="absolute right-0 bottom-0 blur-[300px] translate-x-[90%] translate-y-[50%] -z-10">
            <img id="right_album_cover" class="w-175 h-175 opacity-0 duration-1000" src=""
            alt="{{ Vite::asset('resources/images/album_cover_placeholder.png') }}"
            >
        </div>

    </div>

</x-layout>
