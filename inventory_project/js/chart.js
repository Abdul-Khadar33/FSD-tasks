/* ======================
   BAR CHART - PRODUCT STOCK (REALTIME)
====================== */

let barChart;

function loadStockChart(){

fetch("get_stock_data.php")
.then(res => res.json())
.then(data => {

const ctx = document.getElementById('barChart');

if(!ctx) return;

if(barChart){
barChart.destroy();
}

barChart = new Chart(ctx.getContext('2d'),{

type:'bar',

data:{
labels:data.labels,

datasets:[{
label:'Product Stock',
data:data.data,
backgroundColor:'#2196F3'
}]
},

options:{
responsive:true,
maintainAspectRatio:false,

scales:{
x:{
ticks:{
autoSkip:true,
maxRotation:40,
minRotation:20
}
},
y:{
beginAtZero:true
}
},

animation:false
}

});

});

}

/* INITIAL LOAD */
loadStockChart();

/* AUTO UPDATE EVERY 5 SECONDS */
setInterval(loadStockChart,5000);



/* ======================
   PIE CHART - CATEGORY DISTRIBUTION
====================== */

const pieCanvas = document.getElementById('pieChart');

if(pieCanvas){

new Chart(pieCanvas.getContext('2d'),{

type:'pie',

data:{
labels:['Electronics','Furniture','Stationery'],

datasets:[{
data:[164,18,200],

backgroundColor:[
'#3F51B5',
'#009688',
'#FFC107'
]
}]
},

options:{
responsive:true,
maintainAspectRatio:true,
aspectRatio:1,

plugins:{
tooltip:{
callbacks:{
label:function(context){

let total=context.dataset.data.reduce((a,b)=>a+b,0);
let value=context.raw;
let percent=((value/total)*100).toFixed(1);

return context.label + ": " + percent + "%";

}
}
}
}

}

});

}



/* ======================
   LINE CHART - STOCK TREND
====================== */

const lineCanvas = document.getElementById('lineChart');

if(lineCanvas){

new Chart(lineCanvas.getContext('2d'),{

type:'line',

data:{

labels:[
'Aug 2025',
'Sep 2025',
'Oct 2025',
'Nov 2025',
'Dec 2025',
'Jan 2026',
'Feb 2026'
],

datasets:[{

label:'Stock Movement',

data:[120,150,130,170,160,190,210],

borderColor:'#2196F3',
backgroundColor:'rgba(33,150,243,0.2)',

fill:true,
tension:0.4

}]

},

options:{
responsive:true,
maintainAspectRatio:false
}

});

}



/* ======================
   TOP PRODUCTS CHART
====================== */

const topCanvas = document.getElementById('topProductsChart');

if(topCanvas){

new Chart(topCanvas.getContext('2d'),{

type:'bar',

data:{
labels:topProducts,

datasets:[{
label:'Top Products Stock',
data:topStock,
backgroundColor:'#4CAF50'
}]
},

options:{
responsive:true,
maintainAspectRatio:false,

scales:{
y:{
beginAtZero:true
}
},

animation:{
duration:1500
}

}

});

}