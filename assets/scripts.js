document.addEventListener('DOMContentLoaded', () => {

    // Get all number inputs
    const numberInputs = document.querySelectorAll('input[type="number"]');

    // Function to check if all inputs are valid
    const checkInputs = () => {
        let allValid = true;

        numberInputs.forEach(input => {
            const min = parseFloat(input.getAttribute('min'));
            const max = parseFloat(input.getAttribute('max'));
            let value = parseFloat(input.value);

            // Check if the value is within the min and max range
            if (value < min || value > max || isNaN(value)) {
                allValid = false;
                removeTick(input); // Remove the tick if invalid
            } else {
                addTick(input); // Add tick if valid
            }
        });
    };

    // Function to add the tick mark next to the valid input
    const addTick = (input) => {
        if (!input.classList.contains('valid')) {
            input.classList.add('valid'); // Add valid class to show tick
        }
    };

    // Function to remove the tick mark if the input is invalid
    const removeTick = (input) => {
        input.classList.remove('valid'); // Remove the valid class
    };

    // Set the event listener for input change
    numberInputs.forEach(input => {
        input.addEventListener('input', () => {
            // Check and enforce min/max range
            const min = parseFloat(input.getAttribute('min'));
            const max = parseFloat(input.getAttribute('max'));
            let value = parseFloat(input.value);

            // Correct the value if it's outside the range
            if (value < min) {
                input.value = min;
            } else if (value > max) {
                input.value = max;
            }

            // Check inputs validity after correction
            checkInputs();
        });
    });

    // Initial check for input validity when page loads
    checkInputs();
});

const calculate = () => {
    // Retrieve values from the input fields
    let one = document.querySelector("#one").value;
    let two = document.querySelector("#two").value;
    let three = document.querySelector("#three").value;
    let four = document.querySelector("#four").value;
    let five = document.querySelector("#five").value;
    let six = document.querySelector("#six").value;
    let seven = document.querySelector("#seven").value;
    let eight = document.querySelector("#eight").value;
    let nine = document.querySelector("#nine").value;
    let ten = document.querySelector("#ten").value;

    // Calculate score based on input values
    let scoreOne = parseFloat(one) * 0.3448275862068965;
    let scoreTwo = parseFloat(two) * 1.0526315789473684;
    let scoreThree = parseFloat(three) * 1.7543859649122807;
    let scoreFour = parseFloat(four) * 0.7692307692307692;
    let scoreFive = parseFloat(five) * 5;
    let scoreSix = parseFloat(six) * 4;
    let scoreSeven = parseFloat(seven) * 2.7777777777777777;
    let scoreEight = parseFloat(eight) * 1.1494252873563218;
    let scoreNine = parseFloat(nine) * 3.7037037037037037;
    let scoreTen = parseFloat(ten) * 6.6666666666666666;

    // Calculate total score
    let totalScore = scoreOne + scoreTwo + scoreThree + scoreFour + scoreFive + scoreSix + scoreSeven + scoreEight + scoreNine + scoreTen;

    // Array of motivational messages
    const messages = [
        "Keep pushing forward!",
        "Great job! You're making progress!",
        "Every step counts – keep going!",
        "Believe in yourself, you’re doing amazing!",
        "Success is no accident – keep up the good work!",
        "You're stronger than you think!",
        "Hard work always pays off!",
        "Stay focused, stay positive!",
        "One step at a time – you're doing great!",
        "Don’t stop now, you’ve got this!"
    ];

    // Generate a random motivational message
    const randomMessage = messages[Math.floor(Math.random() * messages.length)];

    // Check if any field is empty
    if (one === "" || two === "" || three === "" || four === "" || five === "" || six === "" || seven === "" || eight === "" || nine === "" || ten === "") {
        document.querySelector("#showdata").innerHTML = "Please enter all the fields";
        return;
    }

    // Display score and message
    document.querySelector("#showdata").innerHTML = `${totalScore.toFixed(2)} out of 1000.`;
    document.querySelector("#message").innerHTML = `${randomMessage}`;

    // Send score data to the backend, then show where it ranks
    const formData = new FormData();
    formData.append("score_one", scoreOne);
    formData.append("score_two", scoreTwo);
    formData.append("score_three", scoreThree);
    formData.append("score_four", scoreFour);
    formData.append("score_five", scoreFive);
    formData.append("score_six", scoreSix);
    formData.append("score_seven", scoreSeven);
    formData.append("score_eight", scoreEight);
    formData.append("score_nine", scoreNine);
    formData.append("score_ten", scoreTen);
    formData.append("score", totalScore);

    fetch("add_score.php", { method: "POST", body: formData })
        .then((res) => (res.ok ? res.json() : null))
        .then((data) => {
            const rankBox = document.querySelector("#rankBox");
            const rankText = document.querySelector("#rankText");
            if (!data || !data.ok || !rankBox || !rankText) return;

            rankText.textContent = `You ranked #${data.rank} of ${data.total} — top ${data.percentile}%.`;
            rankBox.hidden = false;
            window.__f45Share = {
                total: totalScore,
                rank: data.rank,
                outOf: data.total,
                percentile: data.percentile,
            };
        })
        .catch(() => {
            // Leaderboard/rank is a bonus — a network hiccup here shouldn't block the result already shown.
        });
};

const shareScore = () => {
    const s = window.__f45Share;
    const url = "https://joshspires.com.au/projects/f45-calculator/";
    const text = s
        ? `I scored ${s.total.toFixed(1)}/1000 on the F45 Playoffs Score Calculator — ranked #${s.rank} of ${s.outOf} (top ${s.percentile}%). Calculate yours:`
        : "I just calculated my F45 Playoffs score. Calculate yours:";

    if (navigator.share) {
        navigator.share({ title: "F45 Playoffs Score Calculator", text, url }).catch(() => {});
        return;
    }

    if (navigator.clipboard) {
        navigator.clipboard.writeText(`${text} ${url}`).catch(() => {});
    }
    const tweetUrl = `https://twitter.com/intent/tweet?text=${encodeURIComponent(text)}&url=${encodeURIComponent(url)}`;
    window.open(tweetUrl, "_blank", "noopener");
};

const resetInputs = () => {
    // Reset the values of all inputs
    document.querySelector("#one").value = "";
    document.querySelector("#two").value = "";
    document.querySelector("#three").value = "";
    document.querySelector("#four").value = "";
    document.querySelector("#five").value = "";
    document.querySelector("#six").value = "";
    document.querySelector("#seven").value = "";
    document.querySelector("#eight").value = "";
    document.querySelector("#nine").value = "";
    document.querySelector("#ten").value = "";

    // Clear the output messages
    document.querySelector("#showdata").innerHTML = "";
    document.querySelector("#message").innerHTML = "";

    // Hide the rank/share box until the next calculation
    const rankBox = document.querySelector("#rankBox");
    if (rankBox) rankBox.hidden = true;
    window.__f45Share = null;

    // Remove the 'valid' class from all inputs
    const inputs = document.querySelectorAll("input");
    inputs.forEach(input => {
        input.classList.remove("valid");
    });
};