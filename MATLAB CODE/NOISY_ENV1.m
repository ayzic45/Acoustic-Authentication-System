%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
% Time & Frequency Domain for Transmitted signals
% .wav data for both transmitted and recieved signal were obtained 
% seperately, i.e transmitted signal are exported from the SDL
% using the command line at ubuntu
% recieved signal are exported after the recording at reciever side
% using javascripts at reciever1.php, extracted from the 
% original reciever.php 
% then there are imported here on MATLAB analysis
%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
fs = 44e3 ; % default value of sampling frequency 44kHz

%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
%                    1
%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
%Captured Signal for "UKZN-ACOUSTIC-AUTHENTICATION"
acoustic_auth_data = 'TEST1-NOISY ENV1.wav';
[data_set, y] = audioread(acoustic_auth_data);
x = data_set ; % column to row vector conversion
sound(x, y);
%use the plot_funct
plot_func(x, fs,'Amplitude', 'NOISY ENV1: CAPTURED WAVEFORM FOR "UKZN-ACOUSTIC-AUTHENTICA"');

%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
%                    2
%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
%Captured Signal for "UKZN#CodeTest1234_5"
acoustic_auth_data = 'TEST2-NOISY ENV1.wav';
[data_set, y] = audioread(acoustic_auth_data);
x = data_set ; % column to row vector conversion
sound(x, y);
plot_func(x, fs,'Amplitude', 'NOISY ENV1: CAPTURED WAVEFORM FOR "UKZN#CodeTest1234_5"');


%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
%                    3
%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
%Captured Signal for "UKZN#CodeTest1234_5"
acoustic_auth_data = 'AYA796-NOISY ENV1.wav';
[data_set, y] = audioread(acoustic_auth_data);
x = data_set ; % column to row vector conversion
sound(x, y);
plot_func(x, fs,'Amplitude', 'NOISY ENV1: CAPTURED WAVEFORM FOR "DeopvJBqVH4xzMmjAPE02gu"');

%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
%                    4
%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
%Captured Signal for "UKZN#CodeTest1234_5"
acoustic_auth_data = 'AYA4545-NOISY ENV1.wav';
[data_set, y] = audioread(acoustic_auth_data);
x = data_set ; % column to row vector conversion
sound(x, y);
plot_func(x, fs,'Amplitude', 'NOISY ENV1: CAPTURED WAVEFORM FOR "7zAM5OhYmNdu9gJy1QVSZI2e"');

%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
%                    5
%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
%Captured Signal for "UKZN#CodeTest1234_5"
acoustic_auth_data = 'Sabza18-NOISY ENV1.wav';
[data_set, y] = audioread(acoustic_auth_data);
x = data_set ; % column to row vector conversion
sound(x, y);
plot_func(x, fs,'Amplitude', 'NOISY ENV1: CAPTURED WAVEFORM FOR "kXNZBmjYTLqFMCcEgv-tedo3"');

