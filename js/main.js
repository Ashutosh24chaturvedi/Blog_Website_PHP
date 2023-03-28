const navItems = document.querySelector(".nav_items");
const openNavBtn = document.querySelector("#open_nav_btn");
const closeNavBtn = document.querySelector("#close_nav_btn");

// open nav dropdown
const openNav = () => {
  navItems.style.display = "flex";
  openNavBtn.style.display = "none";
  closeNavBtn.style.display = "inline-block";
};

// close nav dropdown
const closeNav = () => {
  navItems.style.display = "none";
  openNavBtn.style.display = "inline-block";
  closeNavBtn.style.display = "none";
};
openNavBtn.addEventListener("click", openNav);

closeNavBtn.addEventListener("click", closeNav);

// dashboard button
const sidebar = document.querySelector("aside");
const showSidebarBtn = document.querySelector("#show_sidebar-btn");
const hideSidebarBtn = document.querySelector("#hide_sidebar-btn");

//shows sidebar on small device
const showSidebar = () => {
  sidebar.style.left = "0";
  showSidebarBtn.style.display = "none";
  hideSidebarBtn.style.display = "inline-block";
};

//hide sidebar on small device
const hideSidebar = () => {
  sidebar.style.left = "-100%";
  showSidebarBtn.style.display = "inline-block";
  hideSidebarBtn.style.display = "none";
};

showSidebarBtn.addEventListener("click", showSidebar);
hideSidebarBtn.addEventListener("click", hideSidebar);
