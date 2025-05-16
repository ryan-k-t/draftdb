const percentage = (dividend, divisor, format = true) => {
    const quotient = divisor === 0 ? divisor : dividend / divisor;
    const result = new Intl.NumberFormat('en-US', {
        minimumFractionDigits: 2,
        maximumFractionDigits: 2,
        notation: 'standard'
    }).format( quotient * 100 );
    return format ? result+'%' : result;
};

export {
    percentage
}