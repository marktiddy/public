import $ from 'jquery';

class MyNotes {
  constructor() {
    this.events();
  }

  events() {
    $('#my-notes').on('click', '.delete-note', this.deleteNote);
    $('#my-notes').on('click', '.edit-note', this.editNote.bind(this));
    $('#my-notes').on('click', '.update-note', this.updateNote.bind(this));
    $('.create-note').on('click', this.createNote.bind(this));
  }

  //Custom methods
  createNote(e) {
    const ourNewPost = {
      title: $('.new-note-title').val(),
      content: $('.new-note-body').val(),
      status: 'publish',
    };

    $.ajax({
      beforeSend: (xhr) => {
        xhr.setRequestHeader('X-WP-Nonce', universityData.nonce);
      },
      url: universityData.root_url + '/wp-json/wp/v2/note/',
      type: 'POST',
      data: ourNewPost,
      success: (response) => {
        $('.new-note-title, .new-note-body').val('');
        $(`
        <li data-id="${response.id}">
        <input value="${response.title.raw}" class="note-title-field" readonly>
        <span class="edit-note"><i class="fa fa-pencil" aria-hidden="true"></i>Edit</span>
        <span class="delete-note"><i class="fa fa-trash-o" aria-hidden="true"></i>Delete</span>
        <textarea class="note-body-field" readonly>${response.content.raw}</textarea>
        <span class="update-note btn btn--blue btn--small"><i class="fa fa-arrow-right" aria-hidden="true"></i>Save</span>
        </li>
        `)
          .prependTo('#my-notes')
          .hide()
          .slideDown();
      },
      error: (response) => {
        console.log('sad times');
        console.log(response);
      },
    });
  }

  deleteNote(e) {
    const thisNote = $(e.target).parents('li');
    $.ajax({
      beforeSend: (xhr) => {
        xhr.setRequestHeader('X-WP-Nonce', universityData.nonce);
      },
      url:
        universityData.root_url + '/wp-json/wp/v2/note/' + thisNote.data('id'),
      type: 'DELETE',
      success: (response) => {
        thisNote.slideUp();
      },
      error: (response) => {
        console.log('sad times');
        console.log(response);
      },
    });
  }

  editNote(e) {
    const thisNote = $(e.target).parents('li');
    if (thisNote.data('state') == 'editable') {
      this.makeNoteReadOnly(thisNote);
    } else {
      this.makeNoteEditable(thisNote);
    }
  }

  updateNote(e) {
    const thisNote = $(e.target).parents('li');
    const ourUpdatedPost = {
      title: thisNote.find('.note-title-field').val(),
      content: thisNote.find('.note-body-field').val(),
    };

    $.ajax({
      beforeSend: (xhr) => {
        xhr.setRequestHeader('X-WP-Nonce', universityData.nonce);
      },
      url:
        universityData.root_url + '/wp-json/wp/v2/note/' + thisNote.data('id'),
      type: 'POST',
      data: ourUpdatedPost,
      success: (response) => {
        console.log('success');
        this.makeNoteReadOnly(thisNote);
      },
      error: (response) => {
        console.log('sad times');
        console.log(response);
      },
    });
  }

  makeNoteEditable(thisNote) {
    thisNote
      .find('.edit-note')
      .html('<i class="fa fa-times" aria-hidden="true"></i>Cancel');
    thisNote
      .find('.note-title-field, .note-body-field')
      .removeAttr('readonly')
      .addClass('note-active-field');
    thisNote.find('.update-note').addClass('update-note--visible');
    thisNote.data('state', 'editable');
  }

  makeNoteReadOnly(thisNote) {
    thisNote
      .find('.edit-note')
      .html('<i class="fa fa-pencil" aria-hidden="true"></i>Edit');
    thisNote
      .find('.note-title-field, .note-body-field')
      .attr('readonly', 'readonly')
      .removeClass('note-active-field');
    thisNote.find('.update-note').removeClass('update-note--visible');
    thisNote.data('state', 'cancel');
  }
}

export default MyNotes;
