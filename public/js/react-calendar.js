// START: Show grouped events in a popup
const ShowGroupEvents = ({ show, events, toggle, visible }) => {
  return /*#__PURE__*/(
    React.createElement(React.Fragment, null,
    visible && /*#__PURE__*/React.createElement("div", { className: "modal-backdrop fade show" }), /*#__PURE__*/
    React.createElement("div", { className: "modal fade " + (visible ? "show d-block" : "") }, /*#__PURE__*/
    React.createElement("div", { className: "modal-dialog modal-dialog-centered modal-dialog-scrollable modal-sm" }, /*#__PURE__*/
    React.createElement("div", { className: "modal-content" }, /*#__PURE__*/
    React.createElement("div", { className: "modal-header" }, /*#__PURE__*/
    React.createElement("h5", { className: "modal-title" }, events.length, " Events"), /*#__PURE__*/
    React.createElement("button", {
      type: "button",
      onClick: toggle,
      className: "btn-close" })), /*#__PURE__*/


    React.createElement("div", {
      className: "modal-body bg-light",
      style: { maxHeight: 400, overflowY: "auto" } },

    events.map((event) => /*#__PURE__*/
    React.createElement("button", {
      key: event.id,
      onClick: () => {
        toggle();
        show(event.id);
      },
      className:
      "btn btn-md d-block w-100 p-0 mb-1 text-truncate mx-auto btn-" +
      event.color },


    event.name))))))));








};
// END: Show grouped events in a popup

// START: Group many events into 1 button
const GroupEvents = ({
  show,
  events,
  maxSize = 4,
  buttonColor = "btn-dark" }) =>
{
  const [showModal, setShowModal] = React.useState(false);

  return /*#__PURE__*/(
    React.createElement(React.Fragment, null, /*#__PURE__*/
    React.createElement(ShowGroupEvents, {
      show: show,
      events: events,
      visible: showModal,
      toggle: () => setShowModal(!showModal) }),

    events.length != 0 && (
    events.length < maxSize ?
    events.map((event) => /*#__PURE__*/
    React.createElement("button", {
      key: event.id,
      onClick: () => show(event.id),
      className:
      "btn btn-sm d-block w-100 p-0 text-truncate mx-auto eventBtn btn-" +
      event.color },


    event.name)) : /*#__PURE__*/



    React.createElement("button", {
      onClick: () => setShowModal(!showModal),
      className:
      buttonColor +
      " btn btn-sm d-block w-100 p-0 text-truncate mx-auto eventBtn" },


    events.length, " events"))));




};
// END: Group many events into 1 button

// START: Show Event Modal
const ShowEventModal = ({ visible, event, update, toggle, erase }) => {
  let a = new Date(event === null || event === void 0 ? void 0 : event.endDate);
  let b = new Date(event === null || event === void 0 ? void 0 : event.startDate);

  return /*#__PURE__*/(
    React.createElement(React.Fragment, null,
    visible && /*#__PURE__*/React.createElement("div", { className: "modal-backdrop fade show" }), /*#__PURE__*/
    React.createElement("div", { className: "modal fade " + (visible ? "show d-block" : "") }, /*#__PURE__*/
    React.createElement("div", { className: "modal-dialog modal-dialog-scrollable" }, /*#__PURE__*/
    React.createElement("div", { className: "modal-content" }, /*#__PURE__*/
    React.createElement("div", { className: "modal-header" }, /*#__PURE__*/
    React.createElement("h5", { className: "modal-title" }, event === null || event === void 0 ? void 0 : event.name), /*#__PURE__*/
    React.createElement("button", {
      type: "button",
      onClick: toggle,
      className: "btn-close" })), /*#__PURE__*/


    React.createElement("div", { className: "modal-body" }, /*#__PURE__*/
    React.createElement("h5", null, /*#__PURE__*/
    React.createElement("span", { className: "badge bg-" + (event === null || event === void 0 ? void 0 : event.color) }, "Start:",
    " ",
    b.toLocaleString("en-US", {
      day: "numeric",
      month: "short",
      year: "numeric",
      hour: "numeric",
      minute: "2-digit" })),

    " ", /*#__PURE__*/
    React.createElement("span", { className: "badge bg-" + (event === null || event === void 0 ? void 0 : event.color) }, "Stop:",
    " ",
    a.toLocaleString("en-US", {
      day: "numeric",
      month: "short",
      year: "numeric",
      hour: "numeric",
      minute: "2-digit" }))), /*#__PURE__*/



    React.createElement("p", { className: "mb-0" }, event === null || event === void 0 ? void 0 : event.description)), /*#__PURE__*/

    React.createElement("div", { className: "modal-footer" }, /*#__PURE__*/
    React.createElement("button", { className: "btn btn-primary", onClick: update }, "Edit"), /*#__PURE__*/


    React.createElement("button", { className: "btn btn-warning", onClick: erase }, "Delete")))))));








};
// END: Show Event Modal

// START: Edit Event Modal
const EditEventModal = ({ colors, event, toggle, visible, updateEvent }) => {
  const [name, setName] = React.useState("");
  const [color, setColor] = React.useState("");
  const [endDate, setEndDate] = React.useState("");
  const [startDate, setStartDate] = React.useState("");
  const [description, setDescription] = React.useState("");

  React.useEffect(() => {var _event$endDate, _event$startDate;
    setName((event === null || event === void 0 ? void 0 : event.name) || "");
    setColor((event === null || event === void 0 ? void 0 : event.color) || "");
    setDescription((event === null || event === void 0 ? void 0 : event.description) || "");
    setEndDate((event === null || event === void 0 ? void 0 : (_event$endDate = event.endDate) === null || _event$endDate === void 0 ? void 0 : _event$endDate.split("T")[0]) || "");
    setStartDate((event === null || event === void 0 ? void 0 : (_event$startDate = event.startDate) === null || _event$startDate === void 0 ? void 0 : _event$startDate.split("T")[0]) || "");
  }, [event]);

  const handleSubmit = e => {
    e.preventDefault();
    let a = new Date(endDate);
    let b = new Date(startDate);
    updateEvent({
      color,
      name: name === null || name === void 0 ? void 0 : name.trim(),
      end: a.toISOString(),
      start: b.toISOString(),
      id: Number.parseInt(event === null || event === void 0 ? void 0 : event.id),
      description: description === null || description === void 0 ? void 0 : description.trim() });

    setName("");
    setColor("");
    setEndDate("");
    setStartDate("");
    setDescription("");
    toggle();
  };

  return /*#__PURE__*/(
    React.createElement(React.Fragment, null,
    visible && /*#__PURE__*/React.createElement("div", { className: "modal-backdrop fade show" }), /*#__PURE__*/
    React.createElement("div", { className: "modal fade " + (visible ? "show d-block" : "") }, /*#__PURE__*/
    React.createElement("div", { className: "modal-dialog modal-dialog-scrollable" }, /*#__PURE__*/
    React.createElement("div", { className: "modal-content" }, /*#__PURE__*/
    React.createElement("div", { className: "modal-header" }, /*#__PURE__*/
    React.createElement("h5", { className: "modal-title" }, "Edit Event"), /*#__PURE__*/
    React.createElement("button", {
      type: "button",
      onClick: toggle,
      className: "btn-close" })), /*#__PURE__*/


    React.createElement("div", { className: "modal-body" }, /*#__PURE__*/
    React.createElement("form", { onSubmit: handleSubmit }, /*#__PURE__*/
    React.createElement("div", { className: "row justify-content-center" }, /*#__PURE__*/
    React.createElement("div", { className: "col-md-6" }, /*#__PURE__*/
    React.createElement("div", { className: "form-group" }, /*#__PURE__*/
    React.createElement("label", { className: "fw-lighter" }, "Name"), /*#__PURE__*/
    React.createElement("input", {
      type: "text",
      value: name,
      required: true,
      placeholder: "Name",
      className: "form-control mb-2",
      onChange: el => setName(el.target.value) }))), /*#__PURE__*/



    React.createElement("div", { className: "col-md-6" }, /*#__PURE__*/
    React.createElement("div", { className: "form-group" }, /*#__PURE__*/
    React.createElement("label", { className: "fw-lighter" }, "Color"), /*#__PURE__*/
    React.createElement("select", {
      value: color,
      required: true,
      className: "form-control mb-2",
      onChange: el => setColor(el.target.value) }, /*#__PURE__*/

    React.createElement("option", { value: "" }, ". . . choose color . . ."),
    colors.map((item, id) => /*#__PURE__*/
    React.createElement("option", { key: id, value: item.value },
    item.name))))), /*#__PURE__*/





    React.createElement("div", { className: "col-md-6" }, /*#__PURE__*/
    React.createElement("div", { className: "form-group" }, /*#__PURE__*/
    React.createElement("label", { className: "fw-lighter" }, "Start Date"), /*#__PURE__*/
    React.createElement("input", {
      type: "date",
      required: true,
      value: startDate,
      placeholder: "Start",
      className: "form-control mb-2",
      onChange: el => setStartDate(el.target.value) }))), /*#__PURE__*/



    React.createElement("div", { className: "col-md-6" }, /*#__PURE__*/
    React.createElement("div", { className: "form-group" }, /*#__PURE__*/
    React.createElement("label", { className: "fw-lighter" }, "Stop Date"), /*#__PURE__*/
    React.createElement("input", {
      type: "date",
      value: endDate,
      required: true,
      min: startDate,
      placeholder: "End",
      className: "form-control mb-2",
      onChange: el => setEndDate(el.target.value) }))), /*#__PURE__*/



    React.createElement("div", { className: "col-md-12" }, /*#__PURE__*/
    React.createElement("div", { className: "form-group" }, /*#__PURE__*/
    React.createElement("label", { className: "fw-lighter" }, "Description"), /*#__PURE__*/
    React.createElement("textarea", {
      rows: 3,
      value: description,
      placeholder: "Description",
      className: "form-control mb-2",
      onChange: el => setDescription(el.target.value) })))), /*#__PURE__*/




    React.createElement("div", { className: "d-grid" }, /*#__PURE__*/
    React.createElement("button", { className: "btn btn-primary", type: "submit" }, "Submit")))))))));










};
// END: Edit Event Modal

// START: Add Event Modal
const AddEventModal = ({ colors, toggle, visible, saveEvent }) => {
  const [name, setName] = React.useState("");
  const [color, setColor] = React.useState("");
  const [endDate, setEndDate] = React.useState("");
  const [startDate, setStartDate] = React.useState("");
  const [description, setDescription] = React.useState("");

  const handleSubmit = e => {
    e.preventDefault();
    let a = new Date(endDate);
    let b = new Date(startDate);
    saveEvent({
      color,
      name: name.trim(),
      end: a.toISOString(),
      start: b.toISOString(),
      description: description.trim() });

    setName("");
    setColor("");
    setEndDate("");
    setStartDate("");
    setDescription("");
    toggle();
  };

  return /*#__PURE__*/(
    React.createElement(React.Fragment, null,
    visible && /*#__PURE__*/React.createElement("div", { className: "modal-backdrop fade show" }), /*#__PURE__*/
    React.createElement("div", { className: "modal fade " + (visible ? "show d-block" : "") }, /*#__PURE__*/
    React.createElement("div", { className: "modal-dialog modal-dialog-scrollable" }, /*#__PURE__*/
    React.createElement("div", { className: "modal-content" }, /*#__PURE__*/
    React.createElement("div", { className: "modal-header" }, /*#__PURE__*/
    React.createElement("h5", { className: "modal-title" }, "Add Event"), /*#__PURE__*/
    React.createElement("button", {
      type: "button",
      onClick: toggle,
      className: "btn-close" })), /*#__PURE__*/


    React.createElement("div", { className: "modal-body" }, /*#__PURE__*/
    React.createElement("form", { onSubmit: handleSubmit }, /*#__PURE__*/
    React.createElement("div", { className: "row justify-content-center" }, /*#__PURE__*/
    React.createElement("div", { className: "col-md-6" }, /*#__PURE__*/
    React.createElement("div", { className: "form-group" }, /*#__PURE__*/
    React.createElement("label", { className: "fw-lighter" }, "Name"), /*#__PURE__*/
    React.createElement("input", {
      type: "text",
      value: name,
      required: true,
      placeholder: "Name",
      className: "form-control mb-2",
      onChange: el => setName(el.target.value) }))), /*#__PURE__*/



    React.createElement("div", { className: "col-md-6" }, /*#__PURE__*/
    React.createElement("div", { className: "form-group" }, /*#__PURE__*/
    React.createElement("label", { className: "fw-lighter" }, "Color"), /*#__PURE__*/
    React.createElement("select", {
      value: color,
      required: true,
      className: "form-control mb-2",
      onChange: el => setColor(el.target.value) }, /*#__PURE__*/

    React.createElement("option", { value: "" }, ". . . choose color . . ."),
    colors.map((item, id) => /*#__PURE__*/
    React.createElement("option", { key: id, value: item.value },
    item.name))))), /*#__PURE__*/





    React.createElement("div", { className: "col-md-6" }, /*#__PURE__*/
    React.createElement("div", { className: "form-group" }, /*#__PURE__*/
    React.createElement("label", { className: "fw-lighter" }, "Start Date"), /*#__PURE__*/
    React.createElement("input", {
      type: "date",
      required: true,
      placeholder: "Day",
      value: startDate,
      className: "form-control mb-2",
      onChange: el => setStartDate(el.target.value) }))), /*#__PURE__*/



    React.createElement("div", { className: "col-md-6" }, /*#__PURE__*/
    React.createElement("div", { className: "form-group" }, /*#__PURE__*/
    React.createElement("label", { className: "fw-lighter" }, "Stop Date"), /*#__PURE__*/
    React.createElement("input", {
      type: "date",
      min: startDate,
      required: true,
      value: endDate,
      placeholder: "Day",
      className: "form-control mb-2",
      onChange: el => setEndDate(el.target.value) }))), /*#__PURE__*/



    React.createElement("div", { className: "col-md-12" }, /*#__PURE__*/
    React.createElement("div", { className: "form-group" }, /*#__PURE__*/
    React.createElement("label", { className: "fw-lighter" }, "Description"), /*#__PURE__*/
    React.createElement("textarea", {
      rows: 3,
      value: description,
      placeholder: "Description",
      className: "form-control mb-2",
      onChange: el => setDescription(el.target.value) })))), /*#__PURE__*/




    React.createElement("div", { className: "d-grid" }, /*#__PURE__*/
    React.createElement("button", { className: "btn btn-primary", type: "submit" }, "Submit")))))))));










};
// END: Add Event Modal

// START: Calendar
const Calendar = () => {
  let today = new Date();
  let grid = { id: 0, day: 0 };
  const monthWeeks = [0, 1, 2, 3, 4, 5];
  const weekDays = ["sun", "mon", "tue", "wed", "thu", "fri", "sat"];
  const colors = [
  { name: "blue", value: "info" },
  { name: "red", value: "danger" },
  { name: "green", value: "success" },
  { name: "yellow", value: "warning" },
  { name: "black", value: "secondary" }];


  const thisMonth = new Date().
  toLocaleDateString("en-GB", {
    year: "numeric",
    month: "2-digit" }).

  split("/").
  reverse().
  join("-");

  const [events, setEvents] = React.useState([
    // {
    //   id: 1,
    //   color: "info",
    //   name: "birthday",
    //   description: "Give me cake",
    //   endDate: `${thisMonth}-15T12:00:11.771Z`,
    //   startDate: `${thisMonth}-14T12:00:11.771Z`
    // }
  ]);

  React.useEffect(() => {
    fetch("/api/v1/calendar").
    then(res => res.json()).
    then(data => {var _data$events;
      setEvents(data === null || data === void 0 ? void 0 : (_data$events = data.events) === null || _data$events === void 0 ? void 0 : _data$events.data);
    });
  }, []);

  const [monthDifference, setMonthDifference] = React.useState(0);
  const [currentEvent, setCurrentEvent] = React.useState({});
  const [month, setMonth] = React.useState({
    today,
    firstDay: new Date(today.getFullYear(), today.getMonth(), 1),
    lastDay: new Date(today.getFullYear(), today.getMonth() + 1, 0) });

  const [showModal, setShowModal] = React.useState(false);
  const [showAddModal, setShowAddModal] = React.useState(false);
  const [showEditModal, setShowEditModal] = React.useState(false);

  React.useEffect(() => {
    today = new Date();
    grid = { id: 0, day: 0 };
    today.setMonth(today.getMonth() + monthDifference);
    setMonth({
      today,
      firstDay: new Date(today.getFullYear(), today.getMonth(), 1),
      lastDay: new Date(today.getFullYear(), today.getMonth() + 1, 0) });

  }, [monthDifference]);

  const getDayEvents = (day = 0) => {
    let a = new Date();
    let b = new Date();

    a.setMonth(a.getMonth() + monthDifference);
    b.setMonth(b.getMonth() + monthDifference);

    a.setDate(day);
    b.setDate(day - 1);

    a.setHours(23);
    b.setHours(0);

    return events.filter(event => {
      let c = new Date(event === null || event === void 0 ? void 0 : event.startDate);
      let d = new Date(event === null || event === void 0 ? void 0 : event.endDate);

      c.setHours(23);
      d.setHours(0);

      return c < a && b < d;
    });
  };

  const saveEvent = ({ name, description, start, end, color }) => {
    const csrfToken = document.head.querySelector('meta[name="csrf-token"]').
    content;

    fetch("/calendar", {
      method: "POST",
      headers: {
        "Content-Type": "application/json",
        "X-CSRF-TOKEN": csrfToken },

      body: JSON.stringify({
        name,
        color,
        description,
        endDate: end,
        startDate: start }) });



    setEvents([
    ...events,
    {
      id: events.length + 1,
      name,
      color,
      description,
      endDate: end,
      startDate: start }]);


  };

  const updateEvent = ({ id, name, description, start, end, color }) => {
    const csrfToken = document.head.querySelector('meta[name="csrf-token"]').
    content;

    fetch(`/calendar/${id}`, {
      method: "PUT",
      headers: {
        "Content-Type": "application/json",
        "X-CSRF-TOKEN": csrfToken },

      body: JSON.stringify({
        name,
        color,
        description,
        endDate: end,
        startDate: start }) });



    setEvents([
    ...events.filter(event => event.id != id),
    {
      id,
      name,
      color,
      description,
      endDate: end,
      startDate: start }]);


  };

  const deleteEvent = () => {
    const csrfToken = document.head.querySelector('meta[name="csrf-token"]').
    content;

    if (confirm("You are about to delete an event :(")) {
      fetch(`/calendar/${currentEvent.id}`, {
        method: "DELETE",
        headers: {
          "Content-Type": "application/json",
          "X-CSRF-TOKEN": csrfToken } });


      setEvents([...events.filter(event => event.id != currentEvent.id)]);
      setShowModal(false);
    }
  };

  return /*#__PURE__*/(
    React.createElement("div", { className: "container my-4" }, /*#__PURE__*/
    React.createElement(AddEventModal, {
      colors: colors,
      visible: showAddModal,
      saveEvent: saveEvent,
      toggle: () => setShowAddModal(!showAddModal) }), /*#__PURE__*/

    React.createElement(ShowEventModal, {
      visible: showModal,
      erase: deleteEvent,
      event: currentEvent,
      toggle: () => setShowModal(!showModal),
      update: () => {
        setShowModal(!showModal);
        setShowEditModal(!showEditModal);
      } }), /*#__PURE__*/

    React.createElement(EditEventModal, {
      colors: colors,
      visible: showEditModal,
      event: currentEvent,
      updateEvent: updateEvent,
      toggle: () => setShowEditModal(!showEditModal) }), /*#__PURE__*/

    React.createElement("div", { className: "d-flex justify-content-between mb-3" }, /*#__PURE__*/
    React.createElement("span", { className: "badge bg-light text-dark fs-4" },
    month.today.toLocaleString("default", {
      month: "long",
      year: "numeric" })), /*#__PURE__*/


    React.createElement("div", null, /*#__PURE__*/
    React.createElement("button", {
      title: "previous month",
      "data-bs-toggle": "tooltip",
      className: "btn btn-secondary rounded-pill ms-1",
      onClick: () => setMonthDifference(monthDifference - 1) }, "\u21C7"), /*#__PURE__*/



    React.createElement("button", {
      title: "next month",
      "data-bs-toggle": "tooltip",
      className: "btn btn-secondary rounded-pill ms-1",
      onClick: () => setMonthDifference(monthDifference + 1) }, "\u21C9"), /*#__PURE__*/



    React.createElement("button", {
      className: "btn btn-primary rounded-pill ms-1",
      onClick: () => setShowAddModal(!showAddModal) }, "\u22B9 Event"))), /*#__PURE__*/





    React.createElement("div", { className: "table-responsive" }, /*#__PURE__*/
    React.createElement("table", { className: "table table-bordered table-responsive text-center" }, /*#__PURE__*/
    React.createElement("thead", null, /*#__PURE__*/
    React.createElement("tr", { className: "text-uppercase" },
    weekDays.map((day, id) => /*#__PURE__*/
    React.createElement("th", { key: id }, day)))), /*#__PURE__*/



    React.createElement("tbody", null,
    monthWeeks.map((week, index) => /*#__PURE__*/
    React.createElement("tr", { key: index },
    weekDays.map((day, id) => {
      if (grid.day || month.firstDay.getDay() == grid.id)
      grid.day++;
      grid.id++;
      if (grid.day > month.lastDay.getDate()) grid.day = 0;

      return /*#__PURE__*/(
        React.createElement("td", { key: id, className: "box " + (!grid.day && "bg-light") },
        grid.day != 0 && /*#__PURE__*/
        React.createElement(React.Fragment, null, /*#__PURE__*/
        React.createElement("span", {
          className:
          monthDifference == 0 &&
          grid.day == new Date().getDate() ?
          "badge bg-primary rounded-pill" :
          "" },


        grid.day), /*#__PURE__*/

        React.createElement(GroupEvents, {
          events: getDayEvents(grid.day),
          show: id => {
            setCurrentEvent(events.find(a => id == a.id));
            setShowModal(!showModal);
          } }))));





    }))))))));







};
// END: Calendar

ReactDOM.render( /*#__PURE__*/React.createElement(Calendar, null), document.getElementById("root"));