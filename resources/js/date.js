export const formatDate = (dt) => {
  var y = dt.getFullYear();
  var m = ('00' + (dt.getMonth()+1)).slice(-2);
  var d = ('00' + dt.getDate()).slice(-2);
  return (y + '-' + m + '-' + d);
}

export const formatDateTime = (dt) => {
  const date = formatDate(dt);
  var h = dt.getHours().toString().padStart(2, '0');
  var m = dt.getMinutes().toString().padStart(2, '0');
  return (date + 'T' + h + ':' + m);
}
