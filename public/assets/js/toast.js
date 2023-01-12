const showToast = (type, text, duration = 3000) => {
  const typeLower = type.toLowerCase();

  if (!['success', 'error'].includes(typeLower)) {
    /* eslint-disable-next-line */
    console.error('The valid value for toast are: success, error');
    return false;
  }

  const background = typeLower === 'success' ? '#11823B' : '#FF0000';

  /* eslint-disable-next-line */
  Toastify({
    text,
    duration,
    close: true,
    gravity: 'bottom', // `top` or `bottom`
    position: 'center', // `left`, `center` or `right`
    stopOnFocus: true, // Prevents dismissing of toast on hover
    style: {
      background,
    },
  }).showToast(type);
};
