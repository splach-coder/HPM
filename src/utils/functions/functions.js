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
