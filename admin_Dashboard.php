<?php
include('php/connection/dbTemporary.php');
include('php/connection/dbConnection.php');

if (!isset($_SESSION['tdbAdminEmail'])) {
    header('location: adminLogin.php');
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/bootstrap.css">
    <link rel="stylesheet" href="css/admin_Dashboard.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/apexcharts/3.42.0/apexcharts.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/apexcharts">


    <link rel="icon" href="img/backgroundImages/logo.png">
    <title>Entong Workz</title>
</head>

<body>
    <div class="sideNav" id="sideNav">
        <h1>Admin</h1>
        <div class="profile">
            <a href="#">
                <img src="img/companyUser/<?php echo $tdbAdminImage ?>" alt="UserImage">
                <?php
                echo "<p> $tdbAdminFirstname </p>";

                ?>
            </a>
        </div>
        <a href="admin_Dashboard.php" class="list">
            <div style="background-color: #16324E;">
                <img id="iconDss" src="img/icons/house.png" alt="dss">
                <span id="textDss">Dashboard</span>
            </div>
        </a>
        <a href="admin_Dashboard_Walkin.php" class="list">
            <div>
                <img id="iconUser" src="img/icons/walkin.png" alt="Add Item">
                <span id="textUsers">Walk In</span>
            </div>
        </a>
        <a href="admin_Dashboard_User.php" class="list">
            <div>
                <img id="iconUser" src="img/icons/users.png" alt="Add Item">
                <span id="textUsers">Users</span>
            </div>
        </a>
        <a href="admin_Dashboard_Additem.php" class="list">
            <div>
                <img id="iconCase" src="img/icons/box.png" alt="Add Item">
                <span id="textItem">Add Item</span>
            </div>
        </a>
        <a href="admin_Dashboard_Inventory.php" class="list">
            <div>
                <img id="iconInven" src="img/icons/inventory.png" alt="Inventory">
                <span id="textInventory">Inventory</span>
            </div>
        </a>
        <a href="admin_Dashboard_Orders.php" class="list">
            <div>
                <img id="iconBank" src="img/icons/cart.png" alt="orders">
                <span id="textBank">Orders</span>
            </div>
        </a>
        <a href="php/admin_Dasboard_ChatBox/admin_Dashboard_ChatBox.php" class="list">
            <div>
                <img id="iconTrash" src="img/icons/support.png" alt="dss">
                <span id="textTrash">Chat Support</span>
            </div>
        </a>
        <a href="admin_Dashboard_Sales.php" class="list">
            <div>
                <img id="iconBank" src="img/icons/cash.png" alt="orders">
                <span id="textBank">Sales</span>
            </div>
        </a>
        <a href="admin_Dashboard_Others.php" class="list">
            <div>
                <img id="iconBank" src="img/icons/others.png" alt="orders">
                <span id="textBank">Others</span>
            </div>
        </a>
    </div>
    <main class="mainContent" id="mainContent">
        <nav>
            <a onclick="closeOpenNav()">
                <img src="img/icons/menu.png" alt="navigation Bar">
            </a>
            <h1>Dashboard</h1>
            <a href="php/php_action/admin_logout.php" class="logout">logout</a>
        </nav>
        <div class="non_Analytics">
            <div class="grid-container">
                <a href="admin_Dashboard_Inventory.php">
                    <div class="grid-item" id="accepted_Order">
                        <div>
                            <h3>Low Stock Items</h3>
                            <img src="img/icons/hiddenTag.png" alt="users image">
                        </div>
                        <?php
                        $sql = "SELECT COUNT(*) AS count_lowest_quantity FROM items WHERE ITEM_QUANTITY = 0";
                        $result = $conn->query($sql);

                        if ($result) {
                            // Fetch the result
                            $row = $result->fetch_assoc();
                            // Get the count of rows with the lowest quantity
                            $countLowestQuantity = $row['count_lowest_quantity'];
                            // Output the count
                        ?>
                            <h2><?php echo $countLowestQuantity; ?></h2>
                        <?php
                        } else {
                            echo "Error executing query: " . $conn->error;
                        }
                        ?>
                    </div>
                </a>
                <a href="admin_Dashboard_Orders.php">
                    <div class="grid-item" id="accepted_Order">
                        <div>
                            <h3>PENDING ORDERS</h3>
                            <img src="img/icons/hiddenTag.png" alt="users image">
                        </div>
                        <?php
                        $sqlForHidden = 'SELECT * FROM ordercode WHERE PACKAGE_STATUS = "ORDER PENDING";';
                        $runForHidden = mysqli_query($conn, $sqlForHidden);
                        $numberForHidden = mysqli_num_rows($runForHidden);
                        ?>
                        <h2><?php echo $numberForHidden; ?></h2>
                    </div>
                </a>
                <a href="admin_Dashboard_Orders.php">
                    <div class="grid-item" id="accepted_Order">
                        <div>
                            <h3>PAYMENT PENDING</h3>
                            <img src="img/icons/hiddenTag.png" alt="users image">
                        </div>
                        <?php
                        $sqlForHidden = 'SELECT * FROM ordercode WHERE PACKAGE_STATUS = "PAYMENT PENDING";';
                        $runForHidden = mysqli_query($conn, $sqlForHidden);
                        $numberForHidden = mysqli_num_rows($runForHidden);
                        ?>
                        <h2><?php echo $numberForHidden; ?></h2>
                    </div>
                </a>

            </div>
        </div>
        <div class="charts" id="charts">

            <div class="charts-card">
                <h2 class="charts_title_Bar">Top 5 Products</h2>
                <div id="bar-chart"></div>
            </div>

            <div class="charts-cards">
                <h2 class="charts_title_Pie">Orders Comming From</h2>
                <div id="chart"></div>
            </div>
        </div>
        <div class="another_Chart_Container">
            <h2 class="charts_title_Sales">Yearly Sales</h2>

            <div id="chartTwo">

            </div>
        </div>

    </main>


    </main>
    <script>
        var options = {
            series: [{
                data: [] // We'll populate this array with data
            }],
            chart: {
                type: 'bar',
                height: 300,
            },
            plotOptions: {
                bar: {
                    borderRadius: 4,
                    horizontal: true,
                }
            },
            dataLabels: {
                enabled: true
            },
            xaxis: {
                categories: [] // We'll populate this array with categories (years)
            },
            colors: ['#091933'] // Set the color to black
        };

        // Function to fetch and update chart data
        function updateChartData() {
            fetch('php/analytics/getDataSales.php')
                .then(response => response.json())
                .then(data => {
                    // Extract data and categories from the response
                    // var salesData = data.map(item => item.sales);
                    var salesData = data.map(item => parseFloat(item.sales).toFixed(2));

                    var years = data.map(item => "YEAR: " + item.year);

                    // Update the chart options with the fetched data
                    chart.updateOptions({
                        series: [{
                            data: salesData
                        }],
                        xaxis: {
                            categories: years
                        }
                    });
                })
                .catch(error => console.error('Error fetching data:', error));
        }

        var chart = new ApexCharts(document.querySelector("#chartTwo"), options);
        chart.render();

        // Fetch and update data every 5 seconds (adjust the interval as needed)
        setInterval(updateChartData, 1000);
    </script>
    <!-- <script>
        var options = {
            series: [{
                data: [] // We'll populate this array with data
            }],
            chart: {
                type: 'bar',
                height: 350,
            },
            plotOptions: {
                bar: {
                    borderRadius: 4,
                    horizontal: true
                }
            },
            dataLabels: {
                enabled: false
            },
            xaxis: {
                categories: [] // We'll populate this array with categories (years)
            }
        };

        // Fetch data from the PHP script
        fetch('php/analytics/getDataSales.php')
            .then(response => response.json())
            .then(data => {
                // Extract data and categories from the response
                var salesData = data.map(item => item.sales);
                var years = data.map(item => item.year);

                // Update the chart options with the fetched data
                chart.updateOptions({
                    series: [{
                        data: salesData
                    }],
                    xaxis: {
                        categories: years
                    }
                });
            })
            .catch(error => console.error('Error fetching data:', error));
        var chart = new ApexCharts(document.querySelector("#chartTwo"), options);
        chart.render();
    </script> -->

    <!-- <script>
        var options = {
            series: [{
                data: [400.20, 430.40, 448.32]
            }],
            chart: {
                type: 'bar',
                height: 350
            },
            plotOptions: {
                bar: {
                    borderRadius: 4,
                    horizontal: true,
                }
            },
            dataLabels: {
                enabled: false
            },
            xaxis: {
                categories: ['2020', '2021', '2022'],
            }
        };

        var chart = new ApexCharts(document.querySelector("#chartTwo"), options);
        chart.render();
    </script> -->

    <script>
        function updatePieChart() {
            // Fetch data from the server
            fetch('php/analytics/getDataPie.php')
                .then(response => response.json())
                .then(data => {
                    var options = {
                        series: data.map(item => item.data),
                        chart: {
                            width: 380,
                            type: 'pie',
                        },
                        // labels: data.map(item => item.name),
                        labels: ['WALK-IN', 'ONLINE'],
                        colors: ['#2962ff', '#d50000'],
                        responsive: [{
                            breakpoint: 580,
                            options: {
                                chart: {
                                    width: 200
                                },
                                legend: {
                                    position: 'bottom'
                                }
                            }
                        }]
                    };

                    // If the chart already exists, update it; otherwise, create a new chart
                    if (window.pieChart) {
                        window.pieChart.updateOptions(options);
                    } else {
                        window.pieChart = new ApexCharts(document.querySelector("#chart"), options);
                        window.pieChart.render();
                    }
                })
                .catch(error => console.error('Error:', error));
        }

        // Update the pie chart every 10 seconds
        setInterval(updatePieChart, 5000);

        // Initial pie chart render
        updatePieChart();
    </script>



    <script>
        function updateChart() {
            fetch('php/analytics/getData.php')
                .then(response => response.json())
                .then(data => {
                    // Create or update the chart
                    if (window.barChart) {
                        // Update the chart data
                        window.barChart.updateSeries([{
                            data: data.map(item => item.item_count),
                        }]);
                    } else {
                        // Initialize the chart
                        var barChartOptions = {
                            series: [{
                                data: data.map(item => item.item_count),
                                name: "Orders",
                            }],
                            chart: {
                                type: "bar",
                                background: "transparent",
                                height: 350,
                                toolbar: {
                                    show: false,
                                },
                            },
                            colors: [
                                "#2962ff",
                                "#d50000",
                                "#2e7d32",
                                "#ff6d00",
                                "#583cb3",
                            ],
                            plotOptions: {
                                bar: {
                                    distributed: true,
                                    borderRadius: 4,
                                    horizontal: false,
                                    columnwidth: "40%",
                                }
                            },
                            dataLabels: {
                                enabled: false,
                            },
                            fill: {
                                opacity: 1,
                            },
                            grid: {
                                borderColor: "#55596e",
                                yaxis: {
                                    lines: {
                                        show: true,
                                    },
                                },
                                xaxis: {
                                    lines: {
                                        show: true,
                                    },
                                },
                            },
                            legend: {
                                labels: {
                                    colors: "#f5f7ff",
                                },
                                show: true,
                                position: "top",
                            },
                            stroke: {
                                colors: ["transparent"],
                                show: true,
                                width: 2
                            },
                            tooltip: {
                                shared: true,
                                intersect: false,
                                theme: "dark",
                            },
                            xaxis: {
                                categories: data.map(item => item.ORDERED_ITEM),
                                title: {
                                    style: {
                                        color: "#f5f7ff",
                                    },
                                },
                                axisBorder: {
                                    show: true,
                                    color: "#55596e",
                                },
                                axisTicks: {
                                    show: true,
                                    color: "#55596e",
                                },
                                labels: {
                                    style: {
                                        colors: "#f5f7ff",
                                    },
                                },
                            },
                            yaxis: {
                                title: {
                                    text: "Count",
                                    style: {
                                        color: "#f5f7ff",
                                    },
                                },
                                axisBorder: {
                                    color: "#55596e",
                                    show: true,
                                },
                                axisTicks: {
                                    color: "#55596e",
                                    show: true,
                                },
                                labels: {
                                    style: {
                                        colors: "#f5f7ff",
                                    },
                                },
                            }
                        };
                        window.barChart = new ApexCharts(document.querySelector("#bar-chart"), barChartOptions);
                        window.barChart.render();
                    }
                    setTimeout(updateChart, 5000);
                })
                .catch(error => {
                    console.error(error);
                    setTimeout(updateChart, 5000);
                });
        }
        updateChart();
    </script>
    <!-- <script>
        fetch('php/analytics/getData.php')
            .then(response => response.json())
            .then(data => {
                var barChartOptions = {
                    series: [{
                        data: data.map(item => item.item_count), // Use item_count from the data
                        name: "Orders",
                    }],
                    chart: {
                        type: "bar",
                        background: "transparent",
                        height: 350,
                        toolbar: {
                            show: false,
                        },
                    },
                    colors: [
                        "#2962ff",
                        "#d50000",
                        "#2e7d32",
                        "#ff6d00",
                        "#583cb3",
                    ],
                    plotOptions: {
                        bar: {
                            distributed: true,
                            borderRadius: 4,
                            horizontal: false,
                            columnwidth: "40%",
                        }
                    },
                    dataLabels: {
                        enabled: false,
                    },
                    fill: {
                        opacity: 1,
                    },
                    grid: {
                        borderColor: "#55596e",
                        yaxis: {
                            lines: {
                                show: true,
                            },
                        },
                        xaxis: {
                            lines: {
                                show: true,
                            },
                        },
                    },
                    legend: {
                        labels: {
                            colors: "#f5f7ff",
                        },
                        show: true,
                        position: "top",
                    },
                    stroke: {
                        colors: ["transparent"],
                        show: true,
                        width: 2
                    },
                    tooltip: {
                        shared: true,
                        intersect: false,
                        theme: "dark",
                    },
                    xaxis: {
                        categories: data.map(item => item.ORDERED_ITEM), // Use ITEM_ID from the data
                        title: {
                            style: {
                                color: "#f5f7ff",
                            },
                        },
                        axisBorder: {
                            show: true,
                            color: "#55596e",

                        },
                        axisTicks: {
                            show: true,
                            color: "#55596e",
                        },
                        labels: {
                            style: {
                                colors: "#f5f7ff",
                            },
                        },
                    },
                    yaxis: {
                        title: {
                            text: "Count",
                            style: {
                                color: "#f5f7ff",
                            },
                        },
                        axisBorder: {
                            color: "#55596e",
                            show: true,
                        },
                        axisTicks: {
                            color: "#55596e",
                            show: true,
                        },
                        labels: {
                            style: {
                                colors: "#f5f7ff",
                            },
                        },
                    }

                };

                var barChart = new ApexCharts(document.querySelector("#bar-chart"), barChartOptions);
                barChart.render();
            })
            .catch(error => console.error(error));
    </script> -->
    <!-- <script>
        var barChartOptions = {
            series: [{
                data: [15, 8, 6, 4, 2],
                name: "Products",
            }],
            chart: {
                type: "bar",
                background: "transparent",
                height: 350,
                toolbar: {
                    show: false,
                },
            },
            colors: [
                "#2962ff",
                "#d50000",
                "#2e7d32",
                "#ff6d00",
                "#583cb3",
            ],
            plotOptions: {
                bar: {
                    distributed: true,
                    borderRadius: 4,
                    horizontal: false,
                    columnwidth: "40%",
                }
            },
            dataLabels: {
                enabled: false,
            },
            fill: {
                opacity: 1,
            },
            grid: {
                borderColor: "#55596e",
                yaxis: {
                    lines: {
                        show: true,
                    },
                },
                xaxis: {
                    lines: {
                        show: true,
                    },
                },
            },
            legend: {
                labels: {
                    colors: "#f5f7ff",
                },
                show: true,
                position: "top",
            },
            stroke: {
                colors: ["transparent"],
                show: true,
                width: 2
            },
            tooltip: {
                shared: true,
                intersect: false,
                theme: "dark",
            },
            xaxis: {
                categories: ['Helmet', 'Wheels', 'Shock', 'Hand Grip', 'Gloves'],
                title: {
                    style: {
                        color: "#f5f7ff",
                    },
                },
                axisBorder: {
                    show: true,
                    color: "#55596e",

                },
                axisTicks: {
                    show: true,
                    color: "#55596e",
                },
                labels: {
                    style: {
                        colors: "#f5f7ff",
                    },
                },
            },
            yaxis: {
                title: {
                    text: "Count",
                    style: {
                        color: "#f5f7ff",
                    },
                },
                axisBorder: {
                    color: "#55596e",
                    show: true,
                },
                axisTicks: {
                    color: "#55596e",
                    show: true,
                },
                labels: {
                    style: {
                        colors: "#f5f7ff",
                    },
                },
            }
        };
        var barChart = new ApexCharts(document.querySelector("#bar-chart-Second"), barChartOptions);
        barChart.render();
    </script> -->
    <script>
        function closeOpenNav() {
            if (document.getElementById("mainContent").style.marginLeft == "15vw") {
                document.getElementById("mainContent").style.marginLeft = "0vw";
                document.getElementById("sideNav").style.width = "0vw";

            } else if (document.getElementById("mainContent").style.marginLeft = "0vw") {
                document.getElementById("mainContent").style.marginLeft = "15vw";
                document.getElementById("sideNav").style.width = "15vw";
            }
        }
    </script>
</body>

</html>