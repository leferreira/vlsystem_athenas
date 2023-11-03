
//cria os gráficos
 var ctx = document.getElementById("myChart");
      var myChart = new Chart(ctx, {
        type: 'bar',
        data: {
          labels: ["Jan", "Ferv", "Mar", "Abr", "Mai", "Jun", "Jul","Ago","Set","Out", "Nov","Dez"],
          datasets: [{
		   label: 'Entradas',
            data: entradas,
            lineTension: 0,
            backgroundColor: '#4e9bbf',
            borderColor: '#4e9bbf',
            borderWidth: 1,
            pointBackgroundColor: '#607bd7'
          },
		  {
			label: 'Saídas',
            data: saidas,
            lineTension: 0,
            backgroundColor: '#f39c8e',
            borderColor: '#f39c8e',
            borderWidth: 1,
            pointBackgroundColor: '#607bd7'
          }
		]
        },
        options: {
          scales: {
            yAxes: [{
              ticks: {
                beginAtZero: false
              }
            }]
          },
          legend: {
            display: true,
          },
          title: {
			display: true,
            text: "Entrada X Saídas",
          }
        }
      });
 

      var ctx = document.getElementById("myChart2");
      var myChart = new Chart(ctx, {
        type: 'line',
        data: {
          labels: ["01", "02", "03", "04", "05", "06", "07","08","09","10","11","12","13","14","15","16","17","18","19","20","21","22","23","24","25","26","27","28","29","30","31"],
          datasets: [{
			label: 'Diários',
            data: diarios,
            lineTension: 0,
            backgroundColor: 'transparent',
            borderColor: '#E34B7A',
            borderWidth: 4,
            pointBackgroundColor: '#E34B7A'
          }]
        },
        options: {
          scales: {
            yAxes: [{
              ticks: {
                beginAtZero: false
              }
            }]
          },
          legend: {
            display: false,
          }
        }
      });