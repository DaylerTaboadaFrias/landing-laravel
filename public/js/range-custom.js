const rangeInput = document.querySelectorAll(".range-input input"),
      priceInput = document.querySelectorAll(".price-input input"),
      range = document.querySelector(".slider .progress");

let priceGap = 0;

let minAnterior = priceInput[0].value;
let maxAnterior = priceInput[1].value;

let timeout;

// Función que verifica y llama a obtenerCursosFiltros con delay
function ejecutarConDelay(min, max) {
    clearTimeout(timeout);
    timeout = setTimeout(() => {
        if (min != minAnterior || max != maxAnterior) {
            minAnterior = min;
            maxAnterior = max;
            obtenerCursosFiltros();
        }
    }, 1500); // 1.5 segundos de retraso
}

// Detecta cambios en los inputs de texto (input-min, input-max)
priceInput.forEach(input => {
    input.addEventListener("input", e => {
        let minPrice = parseInt(priceInput[0].value),
            maxPrice = parseInt(priceInput[1].value);

        if ((maxPrice - minPrice >= priceGap) && maxPrice <= rangeInput[1].max) {
            if (e.target.className === "input-min") {
                rangeInput[0].value = minPrice;
                range.style.left = ((minPrice / rangeInput[0].max) * 100) + "%";
            } else {
                rangeInput[1].value = maxPrice;
                range.style.right = 100 - (maxPrice / rangeInput[1].max) * 100 + "%";
            }

            ejecutarConDelay(minPrice, maxPrice);
        }
    });
});

// Detecta cambios en los inputs de rango (range-min, range-max)
rangeInput.forEach(input => {
    input.addEventListener("input", e => {
        let minVal = parseInt(rangeInput[0].value),
            maxVal = parseInt(rangeInput[1].value);

        if ((maxVal - minVal) < priceGap) {
            if (e.target.className === "range-min") {
                rangeInput[0].value = maxVal - priceGap;
            } else {
                rangeInput[1].value = minVal + priceGap;
            }
        } else {
            priceInput[0].value = minVal;
            priceInput[1].value = maxVal;
            range.style.left = ((minVal / rangeInput[0].max) * 100) + "%";
            range.style.right = 100 - (maxVal / rangeInput[1].max) * 100 + "%";

            ejecutarConDelay(minVal, maxVal);
        }
    });
});
