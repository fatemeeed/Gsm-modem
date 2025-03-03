@extends('app.layouts.master')

@section('content')
    <div class="container">
        {{-- <h1 class="text-center">نمودار منابع و ارتباطات صنعتی</h1> --}}

        {{-- نمایش نمودار برای هر شهر صنعتی --}}
        @foreach ($data as $city)
            <div class="industrial_container">
                <h3 class="city-title">{{ $city['cityName'] }}</h3>

                <div class="row">
                    <!-- نمودار گراف -->
                    <div class="col-md-6">
                        <div id="graph-{{ $loop->index }}" class="graph-container"></div>
                    </div>

                    <!-- نمودار میله‌ای -->
                    <div class="col-md-6">
                        <div class="row">
                            <!-- نمودار میله‌ای برای حجم فعلی آب -->
                            <div class="col-md-6">
                                <canvas id="current-volume-chart-{{ $loop->index }}" width="400"
                                    height="400"></canvas>
                            </div>

                            <!-- نمودار میله‌ای برای فضای ذخیره‌سازی در دسترس -->
                            <div class="col-md-6">
                                <canvas id="available-storage-chart-{{ $loop->index }}" width="400"
                                    height="400"></canvas>
                            </div>
                        </div>

                        <div class="row">
                            <!-- نمایش وضعیت روشن/خاموش -->
                            <div class="equipment-status-container mt-4">
                                <h5 class="title">وضعیت تجهیزات</h5>
                                <ul class="equipment-list">
                                    @foreach ($city['nodes'] as $node)
                                        @php
                                            $status = strtolower($node['status']);
                                        @endphp
                                        <li class="equipment-item">
                                            <span class="status-indicator {{ $status == 'on' ? 'on' : 'off' }}"></span>
                                            <span class="equipment-label">{{ $node['label'] }}</span>
                                            <div class="status-controls">
                                                @livewire('datalogger-toggle', ['datalogger' => $node['dataloggerId']], key($node['dataloggerId']))
                                            </div>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/d3/6.7.0/d3.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const cities = @json($data);

        cities.forEach((city, index) => {
            const nodes = city.nodes;
            const links = city.links;

            // console.log(nodes);



            // تنظیم اندازه گراف به طور داینامیک بر اساس تعداد گره‌ها
            const width = Math.max(500, 100 * nodes.length); // عرض داینامیک
            const height = Math.max(500, 100 * nodes.length); // ارتفاع داینامیک

            // نمودار گراف
            const svg = d3.select(`#graph-${index}`)
                .append("svg")
                .attr("viewBox", `0 0 ${width} ${height}`)
                .attr("preserveAspectRatio", "xMidYMid meet")
                .style("background-color", "#f9f9f9")
                .style("border-radius", "10px")
                .style("padding", "15px")
                .style("box-shadow", "0 4px 12px rgba(0, 0, 0, 0.1)");

            const simulation = d3.forceSimulation(nodes)
                .force("link", d3.forceLink(links).id(d => d.id).distance(150))
                .force("charge", d3.forceManyBody().strength(-300))
                .force("center", d3.forceCenter(width / 2, height / 2))
                .force("collide", d3.forceCollide(100)); // اضافه کردن نیروی جلوگیری از تداخل

            const link = svg.append("g")
                .selectAll("line")
                .data(links)
                .enter().append("line")
                .attr("stroke", "#888")
                .attr("stroke-width", 2);

            const node = svg.append("g")
                .selectAll("g")
                .data(nodes)
                .enter().append("g")
                .attr("class", "node");

            node.each(function(d) {
                if (d.group === 'source') {

                    // ارتفاع ثابت برای استوانه
                    const totalHeight = 100; // ارتفاع کل استوانه به پیکسل (200px)

                    // تقسیم سطح به درصد (سطح از 0 تا 4)
                    const levelValue = +d.level; // تبدیل رشته به عدد
                    const maxLevel = 4; // بالاترین سطح
                    const percentage = (levelValue / maxLevel); // تبدیل سطح به درصد

                    // محاسبه ارتفاع آبی (بر اساس درصد سطح)
                    const blueHeight = totalHeight * percentage; // ارتفاع بخشی که باید آبی شود

                    // اضافه کردن مستطیل خاکستری روشن برای بدنه استوانه
                    d3.select(this).append("rect")
                        .attr("x", -20)
                        .attr("y", 0) // ارتفاع ثابت از بالا
                        .attr("width", 90)
                        .attr("height", totalHeight) // ارتفاع ثابت کل استوانه
                        .attr("fill", "#d3d3d3") // رنگ خاکی روشن
                        .attr("rx", 10)
                        .attr("ry", 10);

                    // اضافه کردن مستطیل آبی برای سطح آب
                    d3.select(this).append("rect")
                        .attr("x", -20)
                        .attr("y", totalHeight - blueHeight) // موقعیت Y با توجه به ارتفاع آبی
                        .attr("width", 90)
                        .attr("height", blueHeight) // ارتفاع آبی
                        .attr("fill", "#344CB7 ") // رنگ آبی
                        .attr("rx", 0)
                        .attr("ry", 0);

                    // اضافه کردن اسم منبع پایین استوانه و در وسط
                    d3.select(this).append("text")
                        .attr("x", 0)
                        .attr("dy", totalHeight + 20) // فاصله از پایین استوانه
                        .attr("text-anchor", "middle")
                        .style("font-size", "14px")
                        .style("fill", "#333")
                        .text(d.label);

                    // اضافه کردن نمایش سطح آب
                    d3.select(this).append("text")
                        .attr("x", 0)
                        .attr("y", 70) // وسط استوانه
                        .attr("text-anchor", "middle")
                        .style("font-size", "12px")
                        .style("fill", "#fff")
                        .text(`level: ${levelValue}`);


                } else if (d.group === 'pump') {
                    d3.select(this).append("image")
                        .attr("xlink:href", "{{ asset('assets/images/pump.png') }}")
                        .attr("x", -30)
                        .attr("y", -30)
                        .attr("width", 60)
                        .attr("height", 60);

                    d3.select(this).append("text")
                        .attr("x", 0)
                        .attr("y", 40)
                        .attr("text-anchor", "middle")
                        .style("font-size", "14px")
                        .style("fill", "#333")
                        .text(d.label);
                } else if (d.group === 'well') {
                    d3.select(this).append("image")
                        .attr("xlink:href", "{{ asset('assets/images/well.png') }}")
                        .attr("x", -40)
                        .attr("y", -40)
                        .attr("width", 80)
                        .attr("height", 80);

                    d3.select(this).append("text")
                        .attr("x", 0)
                        .attr("y", 55)
                        .attr("text-anchor", "middle")
                        .style("font-size", "14px")
                        .style("fill", "#333")
                        .text(d.label);

                    // d3.select(this).append("circle")
                    //     .attr("class", "status-indicator")
                    //     .attr("cx", 0)
                    //     .attr("cy", 55)
                    //     .attr("r", 6);
                }
            });

            simulation.on("tick", () => {
                link.attr("x1", d => d.source.x)
                    .attr("y1", d => d.source.y)
                    .attr("x2", d => d.target.x)
                    .attr("y2", d => d.target.y);

                node.attr("transform", d => `translate(${d.x},${d.y})`);
            });

            simulation.nodes(nodes);
            simulation.force("link").links(links);

            // رسم نمودار میله‌ای برای حجم فعلی آب با Chart.js
            const currentVolumeCtx = document.getElementById(`current-volume-chart-${index}`).getContext('2d');
            new Chart(currentVolumeCtx, {
                type: 'bar',
                data: {
                    labels: ['حجم فعلی آب'],
                    datasets: [{
                        label: 'حجم فعلی (متر مکعب)',
                        data: [city.currentVolum, city.capacity],
                        backgroundColor: ['rgba(54, 162, 235, 0.5)'],
                        borderColor: ['rgba(54, 162, 235, 1)'],
                        borderWidth: 1
                    }]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });

            // رسم نمودار میله‌ای برای فضای ذخیره‌سازی در دسترس با Chart.js
            const availableStorageCtx = document.getElementById(`available-storage-chart-${index}`).getContext(
                '2d');
            new Chart(availableStorageCtx, {
                type: 'bar',
                data: {
                    labels: [' تولید آب '],
                    datasets: [{
                        label: ' تولید آب (لیتر بر ثانیه)',
                        data: [city.availableStorage, city.totalFlowRate],
                        backgroundColor: ['rgba(255, 99, 132, 0.5)'],
                        borderColor: ['rgba(255, 99, 132, 1)'],
                        borderWidth: 1
                    }]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        });
    </script>


    <style>
        .industrial_container {
            margin-top: 150px
        }

        /* استایل عنوان شهر */
        .city-title {
            font-size: 24px;
            color: #333;
            margin-bottom: 20px;
            text-transform: capitalize;
            text-align: center;
            font-weight: bold;
        }

        /* استایل کلی گراف */
        .graph-container {
            height: 500px;
            /* یا مقدار مناسب */
            width: 100%;
            /* مطمئن شوید مقدار صحیح است */
            background-color: #f5f5f5;
            border-radius: 12px;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1);
        }


        .graph-container:hover {
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
        }

        /* استایل کلی بخش تجهیزات */
        .equipment-status-container {
            border: 2px solid #e0e0e0;
            border-radius: 12px;
            padding: 20px;
            background-color: #ffffff;
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.1);
            margin-top: 20px;
        }

        .equipment-list {
            list-style-type: none;
            padding: 0;
        }

        /* استایل کلی برای المان‌های لیست */
        .equipment-item {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 15px 20px;
            margin-bottom: 10px;
            background: linear-gradient(145deg, #ffffff, #e6e6e6);
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            cursor: pointer;
        }

        /* افکت Hover */
        .equipment-item:hover {
            transform: translateY(-5px) scale(1.02);
            box-shadow: 0 8px 15px rgba(0, 0, 0, 0.2);
        }

        @keyframes blink {
            50% {
                opacity: 0;
            }
        }

        /* دایره‌های وضعیت */
        .status-indicator {
            display: inline-block;
            width: 12px;
            height: 12px;
            border-radius: 50%;
            margin-right: 10px;
            margin-left: 5px;
            animation: blink 2s infinite;
            /* اضافه کردن انیمیشن چشمک‌زن */
        }

        .status-indicator.on {
            background-color: #4caf50 !important;
        }

        .status-indicator.off {
            background-color: #f44336 !important;
        }

        /* استایل برای برچسب تجهیزات */
        .equipment-label {
            flex-grow: 1;
            font-size: 16px;
            font-weight: bold;
            color: #333;
        }

        /* کنترل وضعیت (Toggle) */
        .status-controls {
            padding: 5px 10px;
            background: linear-gradient(145deg, #f1f1f1, #e0e0e0);
            border-radius: 5px;
            box-shadow: inset 0 2px 4px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease, background 0.3s ease;
        }

        /* افکت Hover برای Toggle */
        .status-controls:hover {
            transform: scale(1.1);
            background: linear-gradient(145deg, #4caf50, #81c784);
            color: white;
        }

        .toggle-btn {
            padding: 5px 10px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: transform 0.3s ease;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .toggle-btn:hover {
            transform: scale(1.1);
        }

        .btn-on {
            background-color: #4caf50;
            color: white;
        }

        .btn-off {
            background-color: #f44336;
            color: white;
        }

        .title {
            font-size: 20px;
            margin-bottom: 15px;
            color: #333;
        }
    </style>
@endsection
