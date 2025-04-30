document.addEventListener("DOMContentLoaded", function() {
    const circularProgress = document.querySelectorAll(".circular-progress");

    circularProgress.forEach(progressBar => {
        const progressValue = progressBar.querySelector(".percentage");
        const innerCircle = progressBar.querySelector(".inner-circle");
        let startValue = 0;
        const endValue = Number(progressBar.getAttribute("data-percentage"));
        const speed = 50; // Update speed here (time in ms)
        const progressColor = progressBar.getAttribute("data-progress-color");

        // Only run if the progress is not already complete
        if (startValue < endValue) {
            const progress = setInterval(() => {
                if (startValue < endValue) {
                    startValue++; // Increment progress
                    progressValue.textContent = `${startValue}%`;
                    innerCircle.style.backgroundColor = progressBar.getAttribute("data-inner-circle-color");
                    progressBar.style.background = `conic-gradient(${progressColor} ${startValue * 3.6}deg, ${progressBar.getAttribute("data-bg-color")} 0deg)`;
                } else {
                    clearInterval(progress); // Stop when it reaches the target value
                }
            }, speed);
        } else {
            // If the progress is already complete, set the final value directly
            progressValue.textContent = `${endValue}%`;
            innerCircle.style.backgroundColor = progressBar.getAttribute("data-inner-circle-color");
            progressBar.style.background = `conic-gradient(${progressColor} ${endValue * 3.6}deg, ${progressBar.getAttribute("data-bg-color")} 0deg)`;
        }
    });
});