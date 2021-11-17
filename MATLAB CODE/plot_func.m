function plot_func(s, fs, name, plottitle)
% TFPLOT Time and frequency plot
%    plot_func(S, FS, NAME, TITLE) displays a figure window with two subplots.
%    in frequency domain. NAME is the "name" of the signal, e.g., if NAME is
%    's', then the labels on the y-axes will be 's(t)' and '|s_F(f)|',

% Compute the time and frequency scales
t = linspace(0, (length(s)-1) / fs, length(s));

figure;
% Time Domain
plot(t, s);
xlabel('Time [s]'); ylabel(sprintf('%s(t)', name));
title(plottitle);

