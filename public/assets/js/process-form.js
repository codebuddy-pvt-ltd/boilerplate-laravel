const clearFormInputs = (form) => {
  form
    .find(':input')
    .not('button, [type=submit], [type=hidden]')
    .each((i, inputEl) => {
      $(inputEl).val('').prop('checked', false).prop('selected', false);
    });

  form.find('.img').attr('style', '');
  form.find(':input').removeClass('is-invalid');
  form.find('.invalid-feedback').remove();
};

/* eslint-disable-next-line */
const fillFormInputs = (form, data, images) => {
  Object.entries(data).forEach(([name, val]) => {
    form.find(`[name=${name}]`).val(val);
  });

  if (typeof images !== 'undefined') {
    Object.entries(images).forEach(([name, val]) => {
      if (['', 'null'].includes(String(val).trim())) return;

      form
        .find(`[name=${name}]`)
        .parents('.file-input')
        .find('.img')
        .css('background-image', `url(${val})`);
    });
  }
};

const displayErrorMessages = (form, errors, message) => {
  Object.entries(errors).map(([property, messages]) => {
    let inputEl;

    if (property.includes('.')) {
      // handle error message for input type array
      const propertyArr = property.split('.');
      const [inputName, index] = propertyArr;
      inputEl = $(form.find(`[name="${inputName}[]"]`)[index]);
    } else {
      // normal input fields
      inputEl = form.find(`[name=${property}]`);
    }

    const typeInputGroup = inputEl.parent().hasClass('input-group');
    const errMessage = Array.isArray(message) ? messages[0] : messages;

    if (!inputEl || (inputEl && inputEl.attr('type') === 'hidden')) {
      /* eslint-disable-next-line */
      showToast('error', errMessage);
      return;
    }

    inputEl.addClass('is-invalid');

    const errEl = $(
      `<span class="invalid-feedback" style="display: block;"><strong>${errMessage}</strong></span>`
    );

    if (inputEl.attr('type') === 'file' || typeInputGroup) {
      errEl.insertAfter(inputEl.parent());
    } else {
      errEl.insertAfter(inputEl);
    }

    return true;
  });
};

$(document).on('submit', '.ajax-form', function (e) {
  e.preventDefault();

  const loader = 'Processing..';
  const form = $(this);
  const url = form.attr('action');
  const formData = new FormData(form[0]);
  const submitBtnEl = form.find('[type=submit]');
  const submitBtnHTML = submitBtnEl.html();
  const method = form.attr('method') ?? 'POST';

  /* eslint-disable-next-line */
  new Ajax(url, method, formData, true)
    .beforeSend(() => {
      form.find(':input').removeClass('is-invalid');
      form.find('.invalid-feedback').remove();
      submitBtnEl.html(loader);
      submitBtnEl.prop('disabled', true);
    })
    .onError((eventData) => {
      const { message, errors } = eventData.detail.res;

      if (!errors) {
        return;
      }

      displayErrorMessages(form, errors, message);
    })
    .onSuccess((eventData) => {
      const { status, errors, message, clearForm } = eventData.detail.res;

      if (status === 'error') {
        displayErrorMessages(form, errors, message);
      }

      if (clearForm) {
        clearFormInputs(form);
      }
    })
    .onComplete(() => {
      submitBtnEl.html(submitBtnHTML);
      submitBtnEl.prop('disabled', false);
    })
    .send();
});
