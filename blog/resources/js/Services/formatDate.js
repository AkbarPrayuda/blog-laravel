const formatDate = (isoString) => {
    const date = new Date(isoString);
    return date.toLocaleString("id-ID", {
        weekday: "long", // "Senin", "Selasa", dll.
        year: "numeric", // "2024"
        month: "long", // "Juni", "Juli", dll.
    });
};

export default formatDate;
