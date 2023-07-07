/**
 * ---------------------------------------
 * This demo was created using amCharts 5.
 *
 * For more information visit:
 * https://www.amcharts.com/
 *
 * Documentation is available at:
 * https://www.amcharts.com/docs/v5/
 * ---------------------------------------
 */

// Create root element
// https://www.amcharts.com/docs/v5/getting-started/#Root_element
var root = am5.Root.new("chartdiv");

// Set themes
// https://www.amcharts.com/docs/v5/concepts/themes/
root.setThemes([am5themes_Animated.new(root)]);

// Create chart
// https://www.amcharts.com/docs/v5/charts/xy-chart/
var chart = root.container.children.push(
  am5xy.XYChart.new(root, {
    panX: false,
    panY: false,
    wheelX: "panX",
    wheelY: "zoomX",
  })
);

// Add cursor
// https://www.amcharts.com/docs/v5/charts/xy-chart/cursor/
var cursor = chart.set(
  "cursor",
  am5xy.XYCursor.new(root, {
    behavior: "zoomX",
  })
);

cursor.lineY.set("visible", true);

// var date = new Date();
// date.setHours(0, 0, 0, 0);
// var value = 100;

// function generateData() {
//   value = Math.round(Math.random() * 10 - 5 + value);
//   am5.time.add(date, "day", 1);
//   return {
//     date: date.getTime(),
//     value: value,
//   };
// }

// function generateDatas(count) {
//   var data = [];
//   for (var i = 0; i < count; ++i) {
//     data.push(generateData());
//   }
//   return data;
// }

// Create axes
// https://www.amcharts.com/docs/v5/charts/xy-chart/axes/
var xAxis = chart.xAxes.push(
  am5xy.DateAxis.new(root, {
    maxDeviation: 0,
    baseInterval: {
      timeUnit: "day",
      count: 1,
    },
    renderer: am5xy.AxisRendererX.new(root, {
      minGridDistance: 60,
    }),
    tooltip: am5.Tooltip.new(root, {}),
  })
);

var yAxis = chart.yAxes.push(
  am5xy.ValueAxis.new(root, {
    renderer: am5xy.AxisRendererY.new(root, {}),
  })
);

// Add series
// https://www.amcharts.com/docs/v5/charts/xy-chart/series/
var series = chart.series.push(
  am5xy.ColumnSeries.new(root, {
    name: "Series",
    xAxis: xAxis,
    yAxis: yAxis,
    valueYField: "value",
    valueXField: "date",
    tooltip: am5.Tooltip.new(root, {
      labelText: "{valueY}",
    }),
  })
);

series.columns.template.setAll({ strokeOpacity: 0 });

// Add scrollbar
// https://www.amcharts.com/docs/v5/charts/xy-chart/scrollbars/
chart.set(
  "scrollbarX",
  am5.Scrollbar.new(root, {
    orientation: "horizontal",
  })
);

$.ajax({
  url: "../controller/getSaleChart.php",
  method: "GET",
  dataType: "json",
  data: { month: 6 },
  success: function (response) {
    // Iterate over the response array
    for (let i = 0; i < response.length; i++) {
      // Convert the value to a decimal number using parseFloat
      response[i].value = parseFloat(response[i].value);
    }
    
    var data = response;
    console.log(data);
    series.data.setAll(data);

    // Make stuff animate on load
    // https://www.amcharts.com/docs/v5/concepts/animations/
    series.appear(1000);
    chart.appear(1000, 100);
  },
  errors: (err) => {
    console.log("errors: " + err);
  },
});
