 document.getElementById("fetch-weather").addEventListener("click", function() {     const city = document.getElementById("city-input").value;     if (city) { 
        fetchWeather(city); 
    } }); 
function fetchWeather(city) { 
    const apiKey = '961a55ab7ed2af2bf001c2eaa2b82e17';  // Your actual API key     const apiUrl = 
`https://api.openweathermap.org/data/2.5/weather?q=${city}&appid=${apiKey}&units=metri c`; 
    fetch(apiUrl) 
        .then(response => response.json()) 
        .then(data => { 
            // Log the entire API response to see its structure             console.log(data);  
            if (data.cod === 200) {  // Make sure the API call is successful 
                document.getElementById("city-name").innerText = `City: ${data.name}`;                 document.getElementById("temperature").innerText = `Temperature: 
${data.main.temp}°C`;                 document.getElementById("description").innerText = `Weather: ${data.weather[0].description}`; 
            } else {                 alert('City not found or invalid response!'); 
            } 
        }) 
        .catch(error => { 
            console.error('Error fetching weather data:', error); 
        }); 
} 
 
  
