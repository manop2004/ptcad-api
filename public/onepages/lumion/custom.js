const matchList = document.getElementById("matchList");
		
const itemSubdistrict = document.getElementById("subdistrict");
const itemCity = document.getElementById("city");
const itemProvince = document.getElementById("province");
const itemZipcode = document.getElementById("code");

// Get thailand
const getThailand = async () => {
  const response = await fetch("../assets/fontend/json/thailand.json");

  addresses = await response.json();
  //console.log(address);
};

// Search thailand.json and filter it
const searchAddress = (searchText) => {
  // Get matches to current text input
  let matchItems = addresses.filter((address) => {
	const regex = new RegExp(`^${searchText}`, "gi");
	return (
	  address.tambon.match(regex) ||
	  address.tambonEng.match(regex) ||
	  address.amphoe.match(regex) ||
	  address.amphoeEng.match(regex) ||
	  address.province.match(regex) ||
	  address.provinceEng.match(regex)
	);
  });

  if (searchText.length === 0) {
	matchItems = [];
	matchList.innerHTML = "";

	itemCity.value = "";
	itemProvince.value = "";
	itemZipcode.value = "";
  }

  //console.log(matchItems);
  // Add to match list
  outputHtml(matchItems);
};

// Show results in HTML
const outputHtml = (matchItems) => {
  if (matchItems.length > 0) {
	const html = matchItems
	  .map(
		(item) =>
		  `<li><span class="w3-large">${item.tambonEng}, ${item.amphoeEng}, ${item.provinceEng}, ${item.zipcode}</span><br><span class="w3-small w3-opacity">${item.tambon}, ${item.amphoe}, ${item.province}, ${item.zipcode}</span></li>`
	  )
	  .join("");

	//console.log(html);
	matchList.innerHTML = `<ul class="match-items w3-ul w3-hoverable w3-border">${html}</ul>`;
	// Selection item
	matchList.addEventListener("click", selection);
  }
};

function selection(event) {
  const item = event.target;
  //console.log(item.firstChild.textContent);
  itemSubdistrict.value = item.firstChild.textContent;
  matchList.innerHTML = "";

  const items = item.firstChild.textContent.split(", ");
  //console.log(items);

  itemSubdistrict.value = items[0];
  itemCity.value = items[1];
  itemProvince.value = items[2];
  itemZipcode.value = items[3];
}

// Eventlistener
window.addEventListener("DOMContentLoaded", getThailand);
itemSubdistrict.addEventListener("input", () => searchAddress(itemSubdistrict.value));

/********  English Company  ********/
jQuery(function($) {
	/*** Change [name="company"] To .company_form_contact_quote ***/
	// $('[name="company"]').attr("placeholder", "*Please fill this form in english.(Example Co., Ltd.)");
	$('[name="company"]').attr("autocomplete", "new-password");
	var str_current_value = $('[name="company"]').val();
	$('[name="company"]').keyup(function(event) {
		var orgi_text = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890;:<>?._-, ~#&()@!'*+}{][$%^/|=\"";
		var str = $('[name="company"]').val();
		var str_length = str.length;
		var str_length_end = str_length - 1;
		var isEng = true;
		var Char_At = "";
		for (i = 0; i < str_length; i++) {
			Char_At = str.charAt(i);
			if (orgi_text.indexOf(Char_At) == -1) {
				isEng = false;
			}
		}
		if (str_length >= 1) {
			if (isEng == false) {
				$('[name="company"]').val(str_current_value);
			}
		}
	});
});