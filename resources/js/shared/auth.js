export function isLoggedIn() {
    return Boolean(localStorage.getItem('isLoggedIn'));
}

export function logIn() {
    return localStorage.setItem('isLoggedIn', 'true');
}

export function logOut() {
    return localStorage.setItem('isLoggedIn', 'false');
}
