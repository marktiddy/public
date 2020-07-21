import $ from 'jquery';

class Search {
  //1. Describe and create object
  constructor() {
    this.addSearchHTML();
    this.resultsDiv = $('#search-overlay__results');
    this.openButton = $('.js-search-trigger');
    this.closeButton = $('.search-overlay__close');
    this.searchOverley = $('.search-overlay');
    this.isOverlayOpen = false;
    this.isSpinnerVisible = false;
    this.previousValue;
    this.searchField = $('#search-term');
    this.typingTimer;
    this.events();
  }

  //2. Events Method
  events() {
    this.openButton.on('click', this.openOverlay.bind(this));
    this.closeButton.on('click', this.closeOverlay.bind(this));
    $(document).on('keydown', this.keyPressDispatcher.bind(this));
    this.searchField.on('keyup', this.typingLogic.bind(this));
  }

  //3. Methods (function, action)
  openOverlay() {
    this.searchOverley.addClass('search-overlay--active');
    $('body').addClass('body-no-scroll');
    this.searchField.val('');
    setTimeout(() => {
      this.searchField.focus();
    }, 301);
    this.isOverlayOpen = true;
  }

  closeOverlay() {
    this.searchOverley.removeClass('search-overlay--active');
    $('body').removeClass('body-no-scroll');
    this.isOverlayOpen = false;
  }

  keyPressDispatcher(event) {
    if (
      event.keyCode == 83 &&
      !this.isOverlayOpen &&
      !$('input, textarea').is(':focus')
    ) {
      this.openOverlay();
    } else if (event.keyCode == 27 && this.isOverlayOpen) {
      this.closeOverlay();
    }
  }
  typingLogic() {
    if (this.searchField.val() != this.previousValue) {
      clearTimeout(this.typingTimer);
      if (this.searchField.val()) {
        if (!this.isSpinnerVisible) {
          this.resultsDiv.html('<div class="spinner-loader"></div>');
          this.isSpinnerVisible = true;
        }
        this.typingTimer = setTimeout(this.getResults.bind(this), 750);
      } else {
        this.resultsDiv.html('');
        this.isSpinnerVisible = false;
      }
    }

    this.previousValue = this.searchField.val();
  }

  getResults() {
    const pagesUrl = `${universityData.root_url}/wp-json/wp/v2/pages?search=`;
    const postsUrl = `${universityData.root_url}/wp-json/wp/v2/posts?search=`;

    $.when(
      $.getJSON(postsUrl + this.searchField.val()),
      $.getJSON(pagesUrl + this.searchField.val())
    ).then(
      (posts, pages) => {
        var combinedResults = posts[0].concat(pages[0]);
        this.resultsDiv.html(`
      <h2 class="search-overlay__section-title">General Information</h2>
      ${
        combinedResults.length
          ? '<ul class="link-list min-list">'
          : '<p>No general results</p>'
      }
      ${combinedResults.map(
        (item) =>
          `<li><a href="${item.link}">${item.title.rendered}</a>${
            item.authorName ? ` by ${item.authorName}` : ''
          }</li>`
      )}
      ${combinedResults.length ? '</ul>' : ''}
      `);
        this.isSpinnerVisible = false;
      },
      () => {
        this.resultsDiv.html('<p>Unexpected error, please try again</p>');
      }
    );
  }

  addSearchHTML() {
    $('body').append(`<div class="search-overlay" id="search-area-overlay">
  <div class="search-overlay__top">
  <div class="container">
  <i class="fa fa-search search-overlay__icon" aria-hidden="true"></i>
  <input type="text" class="search-term" placeholder="What are you looking for?" id="search-term">
  <i class="fa fa-window-close search-overlay__close" id="search-close-button" aria-hidden="true"></i>

  </div>
  </div>
  <div class="container">
    <div id="search-overlay__results"></div>
  </div>
  </div>`);
  }
}

export default Search;
