function getCurrentTime() {
  const daysOfWeek = ["Sun", "Mon", "Tue", "Wed", "Thu", "Fri", "Sat"];
  const months = [
    "Jan",
    "Feb",
    "Mar",
    "Apr",
    "May",
    "Jun",
    "Jul",
    "Aug",
    "Sep",
    "Oct",
    "Nov",
    "Dec",
  ];

  const now = new Date();
  const dayOfWeek = daysOfWeek[now.getDay()];
  const day = now.getDate();
  const month = months[now.getMonth()];
  const year = now.getFullYear();
  const hours = now.getHours().toString().padStart(2, "0");
  const minutes = now.getMinutes().toString().padStart(2, "0");

  const formattedTime = `${dayOfWeek}, ${day} ${month} ${year} | ${hours}:${minutes} hrs`;
  return formattedTime;
}

function formMessage(message, type, container, position = "full-width") {
  const notification = `<div class="alert alert-${type} alert-dismissible fade show position-${position}" role="alert">
                          ${message}
                          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>`;

  container.prepend(notification);

  setTimeout(function () {
    $(".alert").alert("close");
  }, 4000);
}

function toast(message, type, position = "tr") {
  Toastinette.show(type, 3000, message);
  Toastinette.setPosition(position);
}

function getMonth() {
  // Get the current date
  const currentDate = new Date();

  // Get the month from the current date (returns a zero-based index)
  const monthIndex = currentDate.getMonth();

  // Add 1 to the month index to get the desired representation
  const monthNumber = monthIndex + 1;

  return monthNumber;
}

function convertDashToSpace(word) {
  // Remove leading and trailing dashes
  word = word.replace(/^[-]+|[-]+$/g, "");

  // Split the word by dashes
  var wordArray = word.split("-");

  // Capitalize the first letter of each word
  for (var i = 0; i < wordArray.length; i++) {
    wordArray[i] = wordArray[i].charAt(0).toUpperCase() + wordArray[i].slice(1);
  }

  // Join the words with spaces
  var convertedWord = wordArray.join(" ");

  return convertedWord;
}
