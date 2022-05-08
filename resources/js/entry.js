Nova.booting((Vue, router, store) => {
    Nova.inertia('NovaHealth', require('./views/Health').default);
});
