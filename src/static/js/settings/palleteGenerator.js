$(document).ready(function () {
  const container = $(".container.palleteGenerator");
  const refreshBtn = $(".refresh-btn");

  $("#generate-pallete-button").click(function () {
    $("#palleteGenerator").modal("show");
  });

  const generatePalette = () => {
    container.html(""); // clearing the container

    // Generate random primary color
    const primaryColor = generateRandomColor();

    // Light Primary Color
    const lightPrimaryColor = lightenColor(primaryColor, 20); // Lighten the primary color by 20%

    // Dark Primary Color
    const darkPrimaryColor = darkenColor(primaryColor, 20); // Darken the primary color by 20%

    // White Color
    const whiteColor = "#ffffff";

    // Dark Color
    const darkColor = "#232323";

    // Create primary color box
    createColorBox(primaryColor);

    // Create light primary color box
    createColorBox(lightPrimaryColor);

    // Create dark primary color box
    createColorBox(darkPrimaryColor);

    // Create white color box
    createColorBox(whiteColor);

    // Create dark color box
    createColorBox(darkColor);
  };

  const createColorBox = (color) => {
    const colorBox = $("<li>").addClass("color");
    colorBox.html(`<div class="rect-box" style="background: ${color}"></div>
                     <span class="hex-value">${color}</span>`);
    colorBox.on("click", () => copyColor(colorBox, color));
    container.append(colorBox);
  };

  const copyColor = (elem, hexVal) => {
    const colorElement = elem.find(".hex-value");
    navigator.clipboard
      .writeText(hexVal)
      .then(() => {
        colorElement.text("Copied");
        setTimeout(() => colorElement.text(hexVal), 1000);
      })
      .catch(() => alert("Failed to copy the color code!"));
  };

  const lightenColor = (color, percent) => {
    const num = parseInt(color.replace("#", ""), 16);
    const amt = Math.round(2.55 * percent);
    const R = (num >> 16) + amt;
    const B = ((num >> 8) & 0x00ff) + amt;
    const G = (num & 0x0000ff) + amt;
    const newColor =
      "#" +
      (
        0x1000000 +
        (R < 255 ? (R < 1 ? 0 : R) : 255) * 0x10000 +
        (B < 255 ? (B < 1 ? 0 : B) : 255) * 0x100 +
        (G < 255 ? (G < 1 ? 0 : G) : 255)
      )
        .toString(16)
        .slice(1);
    return newColor;
  };

  const darkenColor = (color, percent) => {
    const num = parseInt(color.replace("#", ""), 16);
    const amt = Math.round(2.55 * percent);
    const R = (num >> 16) - amt;
    const B = ((num >> 8) & 0x00ff) - amt;
    const G = (num & 0x0000ff) - amt;
    const newColor =
      "#" +
      (
        0x1000000 +
        (R > 0 ? R : 0) * 0x10000 +
        (B > 0 ? B : 0) * 0x100 +
        (G > 0 ? G : 0)
      )
        .toString(16)
        .slice(1);
    return newColor;
  };

  const generateRandomColor = () => {
    const randomColor = Math.floor(Math.random() * 16777215).toString(16);
    return `#${randomColor.padStart(6, "0")}`;
  };

  generatePalette(); // Call generatePalette when the page loads

  refreshBtn.on("click", generatePalette);
});
